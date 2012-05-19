<?php

class netersTest extends WebTestCase
{
	public $fixtures=array(
		'neters'=>'neters',
	);

	public function testShow()
	{
		$this->open('?r=neters/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=neters/create');
	}

	public function testUpdate()
	{
		$this->open('?r=neters/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=neters/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=neters/index');
	}

	public function testAdmin()
	{
		$this->open('?r=neters/admin');
	}
}
