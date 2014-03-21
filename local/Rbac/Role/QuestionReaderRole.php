<?php

namespace Omnidoo\Rbac\Role;

class QuestionReaderRole extends AbstractRole
{     #
	public function getChildrenClassNamesList()
	{
		return array(
				'User'
		);
	}

	public function getPermissionClassNamesList()
	{
		return array(
			'QuestionRead',
		);
	}

}
