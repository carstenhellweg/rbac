<?php

namespace Omnidoo\Rbac\Role;

use LogicException;
use Rbac\Role\HierarchicalRole;

abstract class AbstractRole extends HierarchicalRole implements HierarchicalRoleInterface
{

	/**
	 * @var HierarchicalRoleInterface
	 */

	/**
	 * creating a role instance
	 */
	public function __construct()
	{
		$name = get_called_class();
		$this->name = $this->shortName($name);
		$this->init();
	}

	/**
	 * @param $name
	 * @return string
	 */
	protected function shortName($name)
	{
		return trim(str_replace(__NAMESPACE__, '', substr($name, 0, -4)), '\\');
	}

	/**
	 * callback
	 */
	public function init()
	{
		$childrenClassNames = $this->getChildrenClassNamesList();

		if ( ! empty($childrenClassNames))
		{

			$rolesNs = __NAMESPACE__ . '\\';

			foreach ($childrenClassNames as $roleClassName)
			{
				$class = $rolesNs . $roleClassName . 'Role';

				// TODO: try to catch cyclic references at adding of children and break with a logical exception
				// throw new LogicException(
				//	'Recursion supposed by adding of child "'
				//	. $class . '" to the current role instance "'
				//	. get_class(self::$firstInitialized) . '"');

				$child = new $class;
				$this->addChild($child);
			}
		}

		$permissionClassNames = $this->getPermissionClassNamesList();

		if ( ! empty($permissionClassNames))
		{
			$permissionsNs = substr(__NAMESPACE__, 0, -4) . 'Permission\\';

			foreach ($permissionClassNames as $permissionClassName)
			{
				$class = $permissionsNs . $permissionClassName;
				$this->addPermission(new $class);
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function getChildrenClassNamesList()
	{
		return array();
	}

	/**
	 * @inheritdoc
	 */
	public function getPermissionClassNamesList()
	{
		return array();
	}
}
