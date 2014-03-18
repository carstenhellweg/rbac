<?php

namespace Omnidoo\Rbac\Role;

class GuestRole extends AbstractRole
{
	/**
	 * @inherited
	 */
	public function getPermissionClassNamesList()
	{
		return array(
				'PublicPageView'
		);
	}
}
