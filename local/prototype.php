<?php

use Omnidoo\Prototype\Controller;
use Omnidoo\Rbac\RbacService;
use Omnidoo\Rbac\RoleCollectorService;

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

$controller = new Controller(new RbacService(), new RoleCollectorService());

$controller->loadBlogPageAction();
