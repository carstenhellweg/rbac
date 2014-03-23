<?php

namespace Omnidoo\Rbac;


use InvalidArgumentException;
use Omnidoo\Rbac\Role\Behavioural\BehaviouralHierarchicalRoleInterface;
use Omnidoo\Rbac\Role\HierarchicalRoleInterface;
use Traversable;

class RoleCollector
{
	/**
	 * @var
	 */
	protected $behaviouralRoles;
	/**
	 * @param $name
	 * @throws InvalidArgumentException
	 * @return HierarchicalRoleInterface
	 */
	protected function create($name)
	{
		$className = __NAMESPACE__ . '\\Role\\' . $name . 'Role';

		if (!class_exists($className))
		{
			throw new InvalidArgumentException('Invalid class name "' . $className . '" could not create role instance');
		}

		return new $className;
	}

	/**
	 * @return $this
	 */
	public function getInstance()
	{
		return new $this;
	}

	/**
	 * create collection of roles
	 *
	 * @param Traversable|array|string    $roles
	 * @return array
	 */
	public function createCollection($roles)
	{
		if ($roles instanceof Traversable)
		{
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

		if (!empty($this->behaviouralRoles))
		{
			foreach ($this->behaviouralRoles as $behaviorRole)
			{
				$collection[] = $behaviorRole;
			}
		}
		return $collection;
	}

	/**
	 * @param $behaviouralRole
	 */
	public function addBehaviouralRole(BehaviouralHierarchicalRoleInterface $behaviouralRole)
	{
		$this->behaviouralRoles[] = $behaviouralRole;
	}
}
