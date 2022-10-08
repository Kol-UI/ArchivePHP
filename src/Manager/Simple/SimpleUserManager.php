<?php

require_once __DIR__ . "/../UserManageable.php";
require_once __DIR__ . "/../../Entity/User.php";

class SimpleUserManager implements UserManageable
{

	private $user_session = null;

	public function authenticate(string $email, string $password): ?User
	{
		if ($this->user_session == null && trim($email) === "test@test.com" && $password == "1234" && (!isset($_SESSION["user"]) || $_SESSION["user"] == null)) {
			$_SESSION["user"] = $email;
		}

		return $this->getUser();
	}

	public function getUser(): ?User
	{
		if ($this->user_session == null && isset($_SESSION["user"]) && $_SESSION["user"] == "test@test.com") {
			$this->user_session = new User();
			$this->user_session->setEmail("test@test.com");
			$this->user_session->setPassword("1234");
		}

		return $this->user_session;
	}

	public function logout()
	{
		$this->user_session = null;
		session_destroy();
	}
}