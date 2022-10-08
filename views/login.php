<?php

session_start();

require_once __DIR__."/../src/Manager/Pdo/PdoUserManager.php";
require_once __DIR__."/../src/Manager/Pdo/PdoUserManager.php";

$user_manager = new PdoUserManager();

if(!empty($_POST) && isset($_POST["email"]) && isset($_POST["password"]))
{
	$user_manager->authenticate($_POST["email"], $_POST["password"]);
}

if($user_manager->getUser() != null)
{
	header('Location: list.php');
}

?>


<html>
	<head></head>
	<body>

		<h1>Login</h1>
		<form method="POST">
			<input type="email" name="email">
			<input type="password" name="password">
			<input type="submit">
		</form>
	</body>
</html>
