<?php

require_once __DIR__ . "/../UserManageable.php";
require_once __DIR__ . "/../../Entity/User.php";
require_once __DIR__ . "/AbstractPdoManager.php";

class PdoUserManager extends AbstractPdoManager implements UserManageable
{
	/**
	 * @var User|null
	 */
	private $user_session = null;

	public function authenticate(string $email, string $password): ?User
	{
		if ($this->findUserByEmail("test@test.com") == null) {


			$this->create($user);

		}


		$finded_user = $this->findUserByEmail($email);

		if ($this->user_session == null && (!isset($_SESSION["user"]) || $_SESSION["user"] == null)) {

			if ($finded_user != null && $finded_user->getPassword() == sha1($password)) {
				$_SESSION["user"] = $finded_user->getId();
			}

		}

		return $this->getUser();
	}

	public function getUser(): ?User
	{
		if ($this->user_session == null && isset($_SESSION["user"])) {
			$this->user_session = $this->findUserById($_SESSION['user']);
		}

		return $this->user_session;
	}

	public function logout()
	{
		$this->user_session = null;
		session_destroy();
	}


	private function create(User $user): int
	{
		$query = "INSERT INTO user(firstname, lastname, email, password) VALUES (?, ?, ?, ?)";

		$statement = $this->pdo->prepare($query);

		$statement->execute([
			$user->getFirstname(),
			$user->getLastname(),
			$user->getEmail(),
			sha1($user->getPassword())
		]);

		return $this->pdo->lastInsertId();
	}

	/**
	 * @param int $id
	 * @return User|boolean
	 */
	public function findUserById(int $id)
	{
		$query = "SELECT * FROM user WHERE id=:id";

		$statement = $this->pdo->prepare($query);

		$statement->execute([
			':id' => $id
		]);

		$statement->setFetchMode(\PDO::FETCH_CLASS, 'User');

		return $statement->fetch();

	}

	/**
	 * @param string $email
	 * @return User|boolean
	 */
	private function findUserByEmail(string $email)
	{
		$query = "SELECT * FROM user WHERE email=:email";

		$statement = $this->pdo->prepare($query);

		$statement->execute([
			':email' => $email
		]);

		$statement->setFetchMode(\PDO::FETCH_CLASS, 'User');

		return $statement->fetch();
	}
}