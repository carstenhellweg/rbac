<?php

namespace Omnidoo\Rbac;

use Rbac\Rbac;

/**
 * Class RbacService
 * @package Omnidoo\Rbac
 */
class RbacService
{
	/**
	 * @var
	 */
	protected $service;

	/**
	 * @param $config
	 * @return Rbac
	 */
	public function createService($config)
	{
		if (null === $this->service)
		{
			$strategyClass = $config['strategy'];
			$this->service = new Rbac(new $strategyClass);
		}
		return $this->service;
	}
}
