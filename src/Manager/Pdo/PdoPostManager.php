<?php

require_once __DIR__ . "/../PostManageable.php";
require_once __DIR__ . "/AbstractPdoManager.php";
require_once __DIR__ . "/../../Entity/Post.php";

class PdoPostManager extends AbstractPdoManager implements PostManageable
{

	public function add(string $title, string $body, User $user): int
	{
		$query = "INSERT INTO post(title, body, created, user) VALUES (?, ?, ?, ?)";

		$statement = $this->pdo->prepare($query);

		$statement->execute([
			$title,
			$body,
			time(),
			$user->getId()
		]);

		return $this->pdo->lastInsertId();
	}

	public function findAll(): array
	{
		$query = "SELECT * FROM post ORDER BY created DESC";

		$statement = $this->pdo->prepare($query);

		$statement->execute();

		$statement->setFetchMode(\PDO::FETCH_CLASS, 'Post');

		return $statement->fetchAll();
	}

	public function find(int $id)
	{

		$query = "SELECT * FROM post WHERE id= :id";

		$statement = $this->pdo->prepare($query);

		$statement->execute([
			':id' => $id
		]);

		$statement->setFetchMode(\PDO::FETCH_CLASS, 'Post');

		return $statement->fetch();
	}

	public function remove(int $id): bool
	{
		try {
			$query = "DELETE FROM post WHERE id=:id";

			$statement = $this->pdo->prepare($query);

			$statement->execute([
				':id' => $id
			]);

			return true;
		} catch (\PDOException $e) {
			return false;
		}

	}
}