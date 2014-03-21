<?php

namespace Omnidoo\Rbac\Role;

class QuestionModeratorRole extends AbstractRole
{
	public function getChildrenClassNamesList()
	{
		return array(
			'QuestionAuthor',
			'QuestionEditor',
			'QuestionReader'
		);
	}

	public function getPermissionClassNamesList()
	{
		return array(
			'QuestionDelete',
			'QuestionModerate',
		);
	}


}
