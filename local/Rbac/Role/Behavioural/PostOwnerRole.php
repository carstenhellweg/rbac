<?php

namespace Omnidoo\Rbac\Role\Behavioural;

use Omnidoo\Prototype\User;
use Omnidoo\Prototype\BlogPost;
use Omnidoo\Rbac\Role\AbstractRole;

class PostOwnerRole extends AbstractRole implements BehaviouralHierarchicalRoleInterface
{
	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var BlogPost
	 */
	protected $blogPost;

	public function __construct(User $user, BlogPost $blogPost)
	{
		$this->name = $this->canonicalName(get_called_class()) . 'OwnerId' . $user->getId();
		$this->user = $user;
		$this->blogPost = $blogPost;
		parent::init();
	}

	/**
	 * @return array
	 */
	public function getPermissionClassNamesList()
	{
		if ($this->user->getId() === $this->blogPost->getAuthorId())
		{
			return array(
				'QuestionDelete',
				'QuestionUpdate'
			);
		}
		return array();
	}


}
