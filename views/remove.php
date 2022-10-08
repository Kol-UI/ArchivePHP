<?php

session_start();

require_once __DIR__ . '/../src/Manager/Pdo/PdoUserManager.php';
require_once __DIR__ . '/../src/Manager/Pdo/PdoPostManager.php';

$user_manager = new PdoUserManager();
$post_manager = new PdoPostManager();


if ($user_manager->getUser() == null) {
	header('Location: login.php');
}

$post_manager->remove(isset($_GET['id']) ? $_GET["id"] : 0);

header('Location: list.php');


