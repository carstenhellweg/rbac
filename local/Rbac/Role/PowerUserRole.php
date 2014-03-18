<?php

namespace Omnidoo\Rbac\Role;

class AdminRole extends AbstractRole
{

	/**
	 * @return array
	 */
	public function getChildrenClassNamesList()
	{
		return array(
			__NAMESPACE__ . '\\PowerUserRole',
			__NAMESPACE__ . '\\GuestRole'
		);
	}
}
