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
use Omnidoo\Rbac\Permission\QuestionCreate;
use Omnidoo\Rbac\Permission\QuestionDelete;
use Omnidoo\Rbac\Permission\QuestionModerate;
use Omnidoo\Rbac\Permission\QuestionRead;
use Omnidoo\Rbac\Permission\QuestionUpdate;
use Omnidoo\Rbac\RbacService;
use Omnidoo\Rbac\RoleService;
use Rbac\Rbac;
use Rbac\Role\Role;

$rbacService = new RbacService;
$rbac = $rbacService->createService($config);

class User
{
	protected $userId;
	protected $roles;

	public function __construct($id, $roles)
	{
		$this->roles = $roles;
		$this->userId = $id;
	}

	public function getRoles()
	{
		$roles = array();
		foreach (explode(',', $this->roles) as $role)
		{
			$role = trim($role);
			if ('' !== $role)
			{
				$roles[] = $role;
			}
		}

		return $this->roles = $roles;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->userId;
	}
}

class BlogPost
{
	protected $authorId;

	public function __construct(User $author, $text)
	{
		$this->author = $author;
		$this->text = $text;
	}

	/**
	 * @return User
	 */
	public function getAuthor()
	{
		return $this->author;
	}
}

class Controller
{
	/**
	 * @var Omnidoo\Rbac\RbacService
	 */
	protected $rbac;

	public function __construct(RbacService $rbacService, RoleService $roleService)
	{
		$this->rbac = $rbacService->createService();
		$this->rolesService = $roleService;
		if (count($_SERVER['argv']) > 1)
		{
			$argv = $_SERVER['argv'];
			array_shift($argv);
			$this->args = implode(', ', $argv);
		}
		else
		{
			die('Example Usage: ' . $_SERVER['argv'][1] . 'QuestionView QuestionModerate');
		}

		$this->permissions = array(
			new QuestionRead,
			new QuestionCreate,
			new QuestionUpdate,
			new QuestionDelete,
			new QuestionModerate,
		);
	}

	public function loadBlogPageAction()
	{
		$loggedIdInUserId = 10;

		$blogPosts = $this->getBlogPosts();

		foreach ($blogPosts as $num => $post)
		{
			$author = $post->getAuthor();
			$rolesRow = $author->getRoles();
			if ($num % 2)
				echo "\n--------------------------------------------------------------------------------\n";

			echo "\n\tHello user '" . $author->getId() . "' with role(s): [" . implode(', ', $rolesRow) . "]\n\n";
			$roles = $this->rolesService->createCollection($rolesRow);


			if ($loggedIdInUserId === $author->getId())
			{
				$role = new Role('delete-own-post');
				$role->addPermission(new QuestionDelete());
				$role->addPermission(new QuestionUpdate());
				$roles[] = $role;
			}

			foreach ($this->permissions as $knownPermission)
			{
				echo "\n\tPermission testing: " . get_class($knownPermission) . "\n";

				if($this->rbac->isGranted($roles, $knownPermission))
				{
					if ($knownPermission instanceof QuestionRead)
						echo "\n\t +++ You allowed to see our Blog now\n";

					if ($knownPermission instanceof QuestionCreate)
						echo "\n\t +++ You allowed to create a new Blog entry\n";

					if ($knownPermission instanceof QuestionUpdate)
						echo "\n\t +++ You allowed to edit (update) this Blog entry\n";

					if ($knownPermission instanceof QuestionDelete)
						echo "\n\t +++ You allowed to delete this Blog entry\n";

					if ($knownPermission instanceof QuestionModerate)
						echo "\n\t +++ You allowed to moderate this Blog\n";
				}
				else
				{
					echo "\n\t - Not ALLOWED to " . trim(strrchr(get_class($knownPermission), '\\'), '\\') . " in our Blog\n";
				}
				echo "\n";
			}
		}
	}

	/**
	 * @return BlogPost[]
	 */
	protected function getBlogPosts()
	{
		$user = new User(10, $this->args);

		$alien = new User(200, $this->args);
		/** @var BlogPost[] $blogPosts */
		$blogPosts[] = new BlogPost($user, 'Human post sunny');
		$blogPosts[] = new BlogPost($alien, 'Boo alien post darkness');

		return $blogPosts;
	}
}


$controller = new Controller(new RbacService(), new RoleService());

$controller->loadBlogPageAction();
