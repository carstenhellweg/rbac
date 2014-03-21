<?php

namespace Omnidoo\Rbac\Role;

class UserRole extends AbstractRole
{
	public function getChildrenClassNamesList()
	{
		return array(
			'Guest'
		);
	}

}
