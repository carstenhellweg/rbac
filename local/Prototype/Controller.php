<?php
/**
 * Created by PhpStorm.
 * User: al
 * Date: 3/23/14
 * Time: 6:00 PM
 */

namespace Omnidoo\Prototype;

use Omnidoo\Rbac\Permission\QuestionCreate;
use Omnidoo\Rbac\Permission\QuestionDelete;
use Omnidoo\Rbac\Permission\QuestionModerate;
use Omnidoo\Rbac\Permission\QuestionRead;
use Omnidoo\Rbac\Permission\QuestionUpdate;
use Omnidoo\Rbac\RbacService;
use Omnidoo\Rbac\Role\Behavioural\PostOwnerRole;
use Omnidoo\Rbac\RoleCollectorService;

class Controller
{
	/**
	 * @var RbacService
	 */
	protected $rbacService;

	/**
	 * @var RoleCollectorService
	 */
	protected $roleCollectorService;

	/**
	 * @param RbacService          $rbacService
	 * @param RoleCollectorService $roleCollectorService
	 */
	public function __construct(RbacService $rbacService, RoleCollectorService $roleCollectorService)
	{
		$this->rbacService = $rbacService;
		$this->roleCollectorService = $roleCollectorService;
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

	/**
	 *
	 */
	public function loadBlogPageAction()
	{
		$user = new User(10, 'Guest');

		$blogPosts = $this->getBlogPosts();


		$rbac = $this->rbacService->getRbac();

		foreach ($blogPosts as $num => $post)
		{
			$author = $post->getAuthor();
			$rolesRaw = $author->getRolesRaw();
			if ($num % 2)
				echo "\n--------------------------------------------------------------------------------\n";

			echo "\n\tHello user '" . $author->getId() . "' with role(s): [" . implode(', ', $rolesRaw) . "]\n\n";


			foreach ($this->permissions as $knownPermission)
			{
				echo "\n\tPermission testing: " . get_class($knownPermission) . "\n";

				$author->addRole(new PostOwnerRole($user, $post));

				if($rbac->isGranted($author->getRoles(), $knownPermission))
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

