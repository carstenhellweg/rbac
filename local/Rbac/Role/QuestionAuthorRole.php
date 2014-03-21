<?php

namespace Omnidoo\Rbac\Role;

class QuestionAuthorRole extends AbstractRole
{
	public function getChildrenClassNamesList()
	{
		return array(
			'QuestionReader'
		);
	}

	public function getPermissionClassNamesList()
	{
		return array
		(
			'QuestionCreate'
		);
	}
}
