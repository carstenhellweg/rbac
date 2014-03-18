<?php

namespace Omnidoo\Rbac\Role;

class PowerUserRole extends AbstractRole
{

	/**
	 * @inheritdoc
	 */
	public function getChildrenClassNamesList()
	{
		return array(
			'AdvancedUserRole',
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getPermissionClassNamesList()
	{
		return array(
			'QuestionModerate'
		);
	}


}
