<?php

namespace Omnidoo\Prototype;

class BlogPost
{
	protected $authorId;

	public function __construct(User $author, $text)
	{
		$this->author = $author;
		$this->authorId = $author->getId();
		$this->text = $text;
	}

	/**
	 * @return User
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @return mixed
	 */
	public function getAuthorId()
	{
		return $this->authorId;
	}
}
