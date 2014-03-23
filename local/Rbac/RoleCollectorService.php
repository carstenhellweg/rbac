<?php
/**
 * Created by PhpStorm.
 * User: al
 * Date: 3/23/14
 * Time: 3:19 PM
 */

namespace Omnidoo\Rbac;

class RoleCollectorService
{
	/**
	 * @return RoleCollector
	 */
	public function getCollector()
	{
		return new RoleCollector;
	}
}
