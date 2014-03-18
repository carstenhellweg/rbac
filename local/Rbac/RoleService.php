<?php

namespace Omnidoo\Rbac;


use InvalidArgumentException;
use Omnidoo\Rbac\Role\HierarchicalRoleInterface;
use Traversable;

class RoleService
{
	/**
	 * @param $name
	 * @throws InvalidArgumentException
	 * @return HierarchicalRoleInterface
	 */
	public function create($name)
	{
		$className = __NAMESPACE__ . '\\Role\\' . $name . 'Role';

		if ( ! class_exists($className))
		{
			throw new InvalidArgumentException('Invalid class name "' . $className . '" could not create role instance');
		}
		return new $className;
	}

	/**
	 * create collection of roles
	 *
	 * @param Traversable|array|string    $roles
	 * @return array
	 */
	public function createCollection($roles)
	{
		if ($roles instanceof Traversable) {
			$roles = iterator_to_array($roles);
		}

		if ( ! is_array($roles))
		{
			$roles = array($roles);
		}

		$collection = array();
		foreach ($roles as $role)
		{
			$collection[] = $this->create($role);
		}

		return $collection;
	}
}
