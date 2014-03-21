<?php

namespace Omnidoo\Rbac\Role;

class QuestionEditorRole extends AbstractRole
{
	public function getChildrenClassNamesList()
	{
		return array(
			'QuestionReader'
		);
	}

	public function getPermissionClassNamesList()
	{
		return array(
			'QuestionUpdate'
		);
	}

}
