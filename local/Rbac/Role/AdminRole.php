<?php

namespace Omnidoo\Rbac\Role;

class AdminRole extends AbstractRole
{

	/**
	 * @inheritdoc
	 */
	public function getChildrenClassNamesList()
	{
		return array(
			'PowerUserRole',
			'GuestRole'
		);
	}
}
