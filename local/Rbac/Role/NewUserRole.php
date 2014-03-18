<?php

namespace Omnidoo\Rbac\Role;

class NewUserRole extends AbstractRole
{
	/**
	 * @inheritdoc
	 */
	public function getPermissionClassNamesList()
	{
		return array(
	 		'QuestionRead',
			'QuestionCreate'
		);
	}

}
