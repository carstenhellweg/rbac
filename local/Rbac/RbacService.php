<?php

namespace Omnidoo\Rbac;

use Rbac\Rbac;
use Rbac\Traversal\Strategy\RecursiveRoleIteratorStrategy;

/**
 * Class RbacService
 * @package Omnidoo\Rbac
 */
class RbacService
{
	/**
	 * @var Rbac
	 */
	protected $service;

	/**
	 * @param $config
	 * @return Rbac
	 */
	public function getRbac($config = null)
	{
		if (null === $this->service)
		{
			if (null === $config)
			{
				$this->service = new Rbac(new RecursiveRoleIteratorStrategy());
			}
			else
			{
				$strategyClass = $config['strategy'];
				$this->service = new Rbac(new $strategyClass);
			}
		}
		return $this->service;
	}
}
