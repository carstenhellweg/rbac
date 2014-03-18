<?php

namespace Omnidoo\Rbac\Permission;

/**
 * Class AbstractPermission
 * @package Omnidoo\Rbac\Permission
 */
abstract class AbstractPermission implements PermissionInterface
{
	/**
	 * @inherited
	 */
	public function __toString()
	{
		return get_called_class();
	}

}
