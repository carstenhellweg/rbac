<?php

namespace Omnidoo\Rbac\Role;

class AdvancedUserRole extends AbstractRole
{
	/**
	 * @inheritdoc
	 */
	public function getChildrenClassNamesList()
	{
		return array(
			'UserRole'
		);
	}

	/**
	 * @inheritdoc
	 */
	public function getPermissionClassNamesList()
	{
		return array(
			'QuestionTag',
			'QuestionFlag',
			'QuestionDelete',
		);
	}


}
