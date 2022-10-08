<?php

interface UserManageable
{
	public function authenticate(string $email, string $password) : ?User;

	public function getUser() : ?User;

	public function logout();
}