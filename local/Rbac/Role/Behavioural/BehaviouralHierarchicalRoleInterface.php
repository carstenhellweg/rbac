<?php

namespace Omnidoo\Rbac\Role\Behavioural;

use Omnidoo\Rbac\Role\HierarchicalRoleInterface;

interface BehaviouralHierarchicalRoleInterface extends HierarchicalRoleInterface
{

	/**
	 * @return array
	 */
	public function getChildrenClassNamesList();

	/**
	 * hold array of class names of permission
	 * that are related to the concrete role
	 *
	 * @return array
	 */
	public function getPermissionClassNamesList();

	/**
	 * @return string
	 */
	public function __toString();
}
