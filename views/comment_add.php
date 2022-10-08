<?php

session_start();

require_once __DIR__ . '/../src/Manager/Pdo/PdoUserManager.php';
require_once __DIR__ . '/../src/Manager/Pdo/PdoPostManager.php';

$user_manager = new PdoUserManager();
$post_manager = new PdoPostManager();


if ($user_manager->getUser() == null) {
	header('Location: login.php');
}

if(!empty($_POST) && isset($_POST["content"], $_GET["id"]))
{

	$post = $post_manager->find($_GET["id"]);
	if($post !== null && $post !== false)
	{
		$post->addComment($_POST["content"], $user_manager->getUser());
	}

}

header('Location: list.php');
