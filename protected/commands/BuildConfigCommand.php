<?php

class BuildConfigCommand extends CConsoleCommand {
    public $dns;
    public $address;
    public $gateway;
    public $ip;
    public $mac;
    public $count;

    public function run($args) {
        $status = $this->confBuilder();
        echo $status;
    }

    /**
     * Get user address
     *
     * @return array $address
     * 
     */
    private function getAddress() {
        $criteria = new CDbCriteria;
        $criteria->select = 'ip';
    	$criteria->order = 'id DESC';
        $neters = neters::model()->findAll($criteria);
        foreach($neters as $item) {
            $this->address[] = $item->ip;
        }
        return $this->address;
    }

    /**
     * Get user mac address
     *
     * @return array $mac
     * 
     */
    private function getMac() {
        $criteria = new CDbCriteria;
        $criteria->select = 'mac';                
        $criteria->order = 'id DESC';
        $neters = neters::model()->findAll($criteria);
        foreach($neters as $item) {
    	    $mac = str_replace('-', ':', $item->mac);
            $this->mac[] = $mac;
        }
        return $this->mac;
    }

    /**
     * Get gateway address
     *
     * @return array $gateway
     * 
     */
    private function getGateway() {
        $criteria = new CDbCriteria;
        $criteria->select = 'provider';                
        $criteria->order = 'id DESC';
        $neters = neters::model()->findAll($criteria);
        foreach($neters as $item) {
            if($item->provider == 'e-telecom') {
                $this->gateway[] = Yii::app()->params['egateway'];
            } elseif($item->provider == 'well-telecom') {
                $this->gateway[] = Yii::app()->params['wgateway'];
            } elseif($item->provider == 'well-telecom-3') {
                $this->gateway[] = Yii::app()->params['wgateway3'];
            } elseif($item->provider == 'disconnected') {
                $this->gateway[] = '0.0.0.0';
            } elseif($item->provider == 'none') {
                $this->gateway[] = Yii::app()->params['egateway'];
            } else {
                throw new Exception('Provider type is not recognized', 0);
            }
        }
        return $this->gateway;
    }

    /**
     * Get DNS address
     * 
     * @return array $dns
     * 
     */
    private function getDNSaddr() {
        $criteria = new CDbCriteria;
        $criteria->select = 'provider';                
        $criteria->order = 'id DESC';
        $neters = neters::model()->findAll($criteria);
        foreach($neters as $item) {
            if($item->provider == 'e-telecom') {
                $this->dns[] = Yii::app()->params['edns'];
            } elseif($item->provider == 'well-telecom') {
                $this->dns[] = Yii::app()->params['wdns'];
            } elseif($item->provider == 'well-telecom-3') {
                $this->dns[] = Yii::app()->params['wdns3'];
            } elseif($item->provider == 'disconnected') {
                $this->dns[] = '0.0.0.0';
            } elseif($item->provider == 'none') {
                $this->dns[] = Yii::app()->params['edns'];
            } else {
                throw new Exception('Provider type is not recognized', 0);
            }
        }
        return $this->dns;
    }

    /**
     * Get count rows in table
     *
     * @return integer $count
     * 
     */
    public function getCount() {
        $criteria = new CDbCriteria;
        $criteria->select = '*';                
        $this->count = neters::model()->count($criteria);
        return $this->count;
    }

    /**
     * Build config for dhcpd
     * 
     */
    public function confBuilder() {
        $dns     = $this->getDNSaddr();
        $address = $this->getAddress();
        $gateway = $this->getGateway();
        $mac     = $this->getMac();
        $count   = $this->getCount();

        $data = "# have support for DDNS.)\n";
        $data .= "ddns-update-style none;\n";
        $data .= "# днс суффикс\n";
        $data .= "option domain-name \"letinet.ru\";\n";
        $data .= "# время аренды если в запросе не указано время аренды день\n";
        $data .= "default-lease-time 86400;\n";
        $data .= "# максимальное время аренды неделя\n";
        $data .= "max-lease-time 604800;\n";
        $data .= "# If this DHCP server is the official DHCP server for the local\n";
        $data .= "# network, the authoritative directive should be uncommented.\n";
        $data .= "authoritative;\n";
        $data .= "# Use this to send dhcp log messages to a different log file (you also\n";
        $data .= "# have to hack syslog.conf to complete the redirection).\n";
        $data .= "log-facility local7;\n";
        $data .= "#Запрет неизвестных клиентов\n";
        $data .= "deny unknown-clients;\n";
        $data .= "#Запрет выдачи ответов по bootp\n";
        $data .= "deny bootp;\n";
        $data .= "# Ip дхцп сервера в дхцп ответе \n";
        $data .= "option dhcp-server-identifier 172.23.160.2;\n";
        $data .= "subnet 172.23.160.0 netmask 255.255.248.0 {\n";
        $data .= '}';

        for($i = 0; $i < $count; $i++) {
            if($this->gateway[$i] != 'disconnected') {
                $data .= "    host letinet_user_" . $i . " {\n";
	            $data .= "        hardware ethernet " . $mac[$i] . ";\n";
	            $data .= "        fixed-address " . $address[$i] . ";\n";
	            $data .= "        option routers " . $gateway[$i] . ";\n";
	            $data .= "        option domain-name-servers " . $dns[$i] . ";\n"; 
                $data .= "    }\n";
            }
        }

        if(@unlink(Yii::app()->params['config'])) {
            if(!($handle = fopen(Yii::app()->params['config'], 'a+'))) {
                throw new Exception('Not possible to open the file ' . Yii::app()->params['config'], 0);
            } else {
                if (fwrite($handle, $data) === false) {
                    throw new Exception('Not possible to write the file ' . Yii::app()->params['config'], 0);
                }
            }
        } else {
            throw new Exception('Can not remove the old config file', 0);
        }
        $h = "Config file successfully generated. " . date(DATE_RFC822) . " ";
        /**
         * Для возможности перезапуска демона dhcp3-server нужно назначить на файл
         * "/usr/sbin/dhcpd3" группу владельца www-data и установить флаг suid (chmod +s), в правах файла.
         * (sudo chmod u+s /usr/sbin/dhcpd3)
         */
        $h .= exec('/usr/bin/dhcp-restart');
        /*$h .= exec('/etc/init.d/dhcp3-server status');
        $h .= exec('/etc/init.d/dhcp3-server start');
        $h .= exec('/etc/init.d/dhcp3-server status');*/
        return $h;
    }

}

?>
