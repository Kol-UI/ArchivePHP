<?php

require_once __DIR__.'/../Manager/Pdo/PdoUserManager.php';
require_once __DIR__.'/../Manager/Pdo/PdoCommentManager.php';
require_once __DIR__.'/../Entity/Comment.php';

class Post
{
	private $id;
	private $title;
	private $body;
	private $created;
	private $user;

	public function __construct()
	{
		$this->created = time();
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody($body)
	{
		$this->body = $body;
	}

	/**
	 * @return mixed
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return User
	 */
	public function getUser(): ?User
	{
		if (is_numeric($this->user)) {
			$user_manager = new PdoUserManager();
			return $user_manager->findUserById($this->user);
		}
		else
			return unserialize($this->user, [
				'allowed_classes' => ['User']
			]);
	}

	/**
	 * @param mixed $user
	 */
	public function setUser($user)
	{
		if (is_numeric($user))
			$this->user = $user;
		else
			$this->user = serialize($user);
	}

	public function getCommentList()
	{
		if (is_numeric($this->user)) {
			$comment_manager = new PdoCommentManager();
			return $comment_manager->findAllByPost($this);
		}
		else
			return [];
	}

	public function addComment($content, User $user)
	{
		if (is_numeric($this->user)) {
			$comment_manager = new PdoCommentManager();
			return $comment_manager->add($this, $content, $user);
		}
	}
}