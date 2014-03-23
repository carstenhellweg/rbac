<?php
/**
 * Created by PhpStorm.
 * User: al
 * Date: 3/23/14
 * Time: 5:59 PM
 */

namespace Omnidoo\Prototype;

use Omnidoo\Rbac\Role\Behavioural\BehaviouralHierarchicalRoleInterface;
use Omnidoo\Rbac\Role\HierarchicalRoleInterface;
use Omnidoo\Rbac\RoleCollectorService;

class User
{
	protected $userId;
	protected $roles;
	protected $roleCollectorService;
	protected $rolesRaw;

	public function __construct($id, $roles)
	{
		$this->rolesRaw = $roles;
		$this->userId = $id;
		$this->roleCollectorService = new RoleCollectorService;
		$this->roleCollector = $this->roleCollectorService->getCollector();
	}

	public function getRolesRaw()
	{
		$roles = array();
		foreach (explode(',', $this->rolesRaw) as $role)
		{
			$role = trim($role);
			if ('' !== $role)
			{
				$roles[] = $role;
			}
		}

		return $roles;
	}

	/**
	 * @return HierarchicalRoleInterface[]|BehaviouralHierarchicalRoleInterface[]
	 */
	public function getRoles()
	{
		if (null === $this->roles)
		{
			$this->roles = $this->roleCollector->createCollection($this->getRolesRaw());
		}
		return $this->roles;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->userId;
	}

	/**
	 * @param string|HierarchicalRoleInterface|BehaviouralHierarchicalRoleInterface $role
	 * @return $this
	 */
	public function  addRole($role)
	{
		if ($role instanceof BehaviouralHierarchicalRoleInterface)
		{
			$roleCollector = $this->roleCollectorService->getCollector();
			$roleCollector->addBehaviouralRole($role);
			$this->roleCollector = $roleCollector;
		}
		elseif($role instanceof HierarchicalRoleInterface)
		{
			$this->roles[] = $role;

		}
		elseif(is_string($role))
		{
			$this->roles = null;
			$this->rolesRaw .= ',' . $role;
		}
		else
		{
			throw new \InvalidArgumentException(
					'Invalid Role could be string, HierarchicalRoleInterface or BehaviouralHierarchicalRoleInterface'
			);
		}
		return $this;
	}
}
