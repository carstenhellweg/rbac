<?php
/**
 * Created by PhpStorm.
 * User: al
 * Date: 3/18/14
 * Time: 12:47 PM
 */

namespace Omnidoo\Rbac\Role;


use Rbac\Role\HierarchicalRoleInterface as RbacHierarchicalRoleInterface;

interface HierarchicalRoleInterface extends RbacHierarchicalRoleInterface
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
}
