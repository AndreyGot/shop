<?php
namespace Acme\ShopBundle\Event;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;

class EntityChangeEvent extends Event 
{
	private $controller;
	private $entity;
	private $data;
	private $method;

	/**
	 * Constructor
	 */
	public function __construct(Controller $controller, $entity, $data, $method)
	{
	    $this->controller = $controller;
	    $this->entity     = $entity;
	    $this->data       = $data;
	    $this->method     = $method;
	}

	public function getController () {
		return $this->controller;
	}

	public function getEntity () {
		return $this->entity;
	}

	public function getData () {
		return $this->data;
	}

	public function getMethod () {
		return $this->method;
	}

	public function isMethodCreate () {
		return $this->method === 'create';
	}

	public function isMethodEdit () {
		return $this->method === 'edit';
	}
}