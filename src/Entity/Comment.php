<?php
require_once __DIR__.'/../Manager/Pdo/PdoUserManager.php';
require_once __DIR__.'/../Manager/Pdo/PdoPostManager.php';
require_once __DIR__.'/../Entity/Post.php';

class Comment
{
	public $id;
	public $content;
	public $user;
	public $created;
	public $post;

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
	public function setId($id): void
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param mixed $content
	 */
	public function setContent($content): void
	{
		$this->content = $content;
	}

	/**
	 * @return User
	 */
	public function getUser() : ?User
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
	public function setUser($user): void
	{
		if (is_numeric($user))
			$this->user = $user;
		else
			$this->user = serialize($user);
	}

	/**
	 * @return mixed
	 */
	public function getPost()
	{
		if (is_numeric($this->post)) {
			$post_manager = new PdoPostManager();
			return $post_manager->find($this->post);
		}
		else
			return unserialize($this->post, [
				'allowed_classes' => ['Post']
			]);
	}

	/**
	 * @param mixed $post
	 */
	public function setPost($post): void
	{
		if (is_numeric($post))
			$this->post = $post;
		else
			$this->post = serialize($post);
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
	public function setCreated($created): void
	{
		$this->created = $created;
	}
}