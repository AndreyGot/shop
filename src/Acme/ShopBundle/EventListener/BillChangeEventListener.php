<?php
namespace Acme\ShopBundle\EventListener;

use Acme\ShopBundle\Event\EntityChangeEvent;
use Symfony\Component\DependencyInjection\Container;

class BillChangeEventListener
{
	private $container;

	/**
	 * Constructor
	 */
	public function __construct(Container $container)
	{
    $this->container = $container;
	}

	private function getContainer() {
		return $this->container;
	}

	public function billChange (EntityChangeEvent $event) {
		$container = $this->getContainer();
		$session   = $container->get('session');
		$bill      = $event->getEntity();
		if (!$session->getId()) {
			$session->start();
		}
    
    $token = $container->get('security.context')->getToken();
    // if ($token->isAuthenticated()) {
    if (false) {
    	$user = $token->getUser();

    	$bill->setUser($user);
    } else {
    	$bill->setSession($session->getId());
    }
	}
}