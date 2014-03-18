<?php
/**
 * Created by PhpStorm.
 * User: al
 * Date: 3/17/14
 * Time: 1:07 PM
 */

namespace Omnidoo\Rbac\Permission;

abstract class AbstractPermission implements PermissionInterface
{
	/**
	 * @inherited
	 */
	public function __toString()
	{
		return get_class();
	}

}
