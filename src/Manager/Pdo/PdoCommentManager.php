<?php

require_once __DIR__ . "/../CommentManageable.php";
require_once __DIR__ . "/AbstractPdoManager.php";
require_once __DIR__ . "/../../Entity/Comment.php";

class PdoCommentManager extends AbstractPdoManager implements CommentManageable
{

	public function findAllByPost(Post $post): array
	{
		$statement = $this->pdo->prepare("SELECT * FROM comment WHERE post = :postId ORDER BY created ASC");
		$statement->execute([
			':postId' => $post->getId()
		]);

		$statement->setFetchMode(PDO::FETCH_CLASS, 'Comment');


		return $statement->fetchAll();
	}

	public function add(Post $post, $content, User $user): int
	{
		$statement = $this->pdo->prepare('INSERT INTO comment(content, user, post, created) VALUES (:content, :userId, :post, :created)');
		$statement->execute([
			':content' => $content,
			':userId'  => $user->getId(),
			':created' => time(),
			':post' => $post->getId()
		]);

		return $this->pdo->lastInsertId();
	}
}