<?php
namespace Acme\ShopBundle\EventListener;

use Acme\ShopBundle\Event\EntityChangeEvent;
use Symfony\Component\DependencyInjection\Container;

class UserChangeEventListener
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

	public function userChange (EntityChangeEvent $event) {
		if ($event->isMethodCreate()) {
			$container       = $this->getContainer();
			$passwordEncoder = $container->get('security.password_encoder');
			$user            = $event->getEntity();
			$password        = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($password);
		}
	}
}
