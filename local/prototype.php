<?php

set_include_path(
		dirname(__DIR__)
		. PATH_SEPARATOR
		. dirname(__DIR__) . '/src'
		. PATH_SEPARATOR
		. get_include_path()
);
function autoLoad($className)
{
	$className = str_replace('Omnidoo\\', 'local/', $className);
	$className = str_replace('\\', '/', $className) . '.php';
	$file = stream_resolve_include_path($className);
	if (false !== $file)
	{
		return include $file;
	}
	return false;
}
spl_autoload_register('autoLoad');

$config = array(
		'strategy' => 'Rbac\Traversal\Strategy\RecursiveRoleIteratorStrategy'
);

use Omnidoo\Rbac\Permission\PublicPageView;
use Omnidoo\Rbac\Permission\QuestionModerate;
use Omnidoo\Rbac\Permission\QuestionUpdate;
use Omnidoo\Rbac\RbacService;
use Omnidoo\Rbac\RoleService;

$rbacService = new RbacService;
$rbac = $rbacService->createService($config);

class User
{
	protected $roles;

	public function getRoles($rolesFromDb)
	{
		$roles = array();
		foreach (explode(',', $rolesFromDb) as $role)
		{
			$role = trim($role);
			if ('' !== $role)
			{
				$roles[] = $role;
			}
		}

		return $this->roles = $roles;
	}
}

$user = new User;

$roleService = new RoleService;
$roles = $roleService->createCollection($user->getRoles('AdvancedUser,Guest'));

if ($rbac->isGranted($roles, new PublicPageView))
{
	echo "Du darfs!";
}

$user2 = new User;
$roles2 = $roleService->createCollection($user2->getRoles('PowerUser,Admin'));

if ($rbac->isGranted($roles2, new PublicPageView))
{
	echo "Du darfs2!";
}

