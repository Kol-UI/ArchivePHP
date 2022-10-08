<?php

interface CommentManageable
{
	public function findAllByPost(Post $post) : array;

	public function add(Post $post, $content, User $user) : int;
}