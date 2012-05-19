<?php

class archiveTest extends WebTestCase
{
	public $fixtures=array(
		'archives'=>'archive',
	);

	public function testShow()
	{
		$this->open('?r=archive/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=archive/create');
	}

	public function testUpdate()
	{
		$this->open('?r=archive/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=archive/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=archive/index');
	}

	public function testAdmin()
	{
		$this->open('?r=archive/admin');
	}
}
