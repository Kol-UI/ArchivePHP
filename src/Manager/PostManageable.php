<?php

interface PostManageable
{
	public function add(string $title, string $body, User $user): int;

	public function findAll(): array;

	public function find(int $id);

	public function remove(int $id): bool;
}