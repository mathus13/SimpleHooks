<?php

use \Ethereal\Hooks;

require_once dirname(__DIR__).'/vendor/autoload.php';

class HooksTest extends \PHPUnit_Framework_TestCase
{
	private $hookSystem;

	public function setup()
	{
		$this->hookSystem = new \Ethereal\Hooks;
	}

	public function testEmptyTopic()
	{
		$data = array();
		$topic = 'test.topic';
		$return = $this->hookSystem->fire($topic, $data);
		$this->assertTrue($data == $return);
	}

	public function testModiedData()
	{
		$data = array('value' => 5);
		$topic = 'test.topic';
		$class = new \tester;
		$method = 'double';
		$this->hookSystem->addListener($topic, $class, $method);
		$return = $this->hookSystem->fire($topic, $data);
		$this->assertTrue($return['value'] == 10);
	}
}

class tester
{
	public function double(array $data)
	{
		if (!isset($data['value'])) {
			return $data;
		}
		$data['value'] = ($data['value'] * 2);
		return $data;
	}
}