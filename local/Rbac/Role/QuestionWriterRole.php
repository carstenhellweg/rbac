<?php

namespace Omnidoo\Rbac\Role;

class QuestionWriterRole extends AbstractRole
{
	public function getChildrenClassNamesList()
	{
		return array(
			'QuestionAuthor',
			'QuestionEditor'
		);
	}
}
