<?php

namespace Omnidoo\Rbac\Role;

class NewUserRole extends AbstractRole
{

	/**
	 * @return array
	 */
	public function getChildrenClassNamesList()
	{
		return array(
			__NAMESPACE__ . '\\NewUserRole',
		);
	}
}
