<?php

require_once __DIR__ . "/../PostManageable.php";
require_once __DIR__ . "/../../Entity/Post.php";

class SimplePostManager implements PostManageable
{
	public function __construct()
	{
		if (!isset($_COOKIE["post_list"]))
			$this->save([]);
	}

	public function add(string $title, string $body, User $user): int
	{

		$post_list = $this->findAll();

		$post = new Post();
		$post->setId($this->getLastPostId() + 1);
		$post->setBody($body);
		$post->setTitle($title);
		$post->setUser($user);
		$post->setCreated(new \DateTime());

		$post_list[] = $post;

		$this->save($post_list);

		return $post->getId();
	}

	public function findAll(): array
	{
		return unserialize($_COOKIE["post_list"] ?? [], [
			'allowed_classes' => ['Post']
		]);
	}

	public function find(int $id): ?Post
	{
		$post_list = $this->findAll();
		/** @var Post $post */
		foreach ($post_list as $post) {
			if ($post->getId() == $id)
				return $post;
		}

		return null;
	}

	public function remove(int $id): bool
	{
		$post_list = $this->findAll();
		/** @var Post $post */
		foreach ($post_list as $i => $post) {
			if ($post->getId() == $id) {
				unset($post_list[$i]);
				$this->save($post_list);
				return true;
			}
		}

		return false;
	}

	private function save($array)
	{
		setcookie("post_list", serialize($array), time() + 60 * 60 * 24 * 30);
	}

	private function getLastPostId()
	{
		$last_id = 0;
		/** @var Post $post */
		foreach ($this->findAll() as $key => $post) {
			if ($post->getId() > $last_id) {
				$last_id = $post->getId();
			}
		}
		return $last_id;
	}
}