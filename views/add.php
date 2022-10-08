<?php

session_start();

require_once __DIR__ . '/../src/Manager/Pdo/PdoUserManager.php';
require_once __DIR__ . '/../src/Manager/Pdo/PdoPostManager.php';

$user_manager = new PdoUserManager();
$post_manager = new PdoPostManager();


if ($user_manager->getUser() == null) {
	header('Location: login.php');
}

if (isset($_POST['title'], $_POST['body'])) {
    $post_manager->add($_POST['title'], $_POST['body'], $user_manager->getUser());

    header('Location: list.php');

}


?>


<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
<h1>Ajouter un post</h1>
<form method="post">
    <div>
        <label for="title">Title</label>
        <input type="text" name="title">
    </div>
    <div>
        <label for="body">Body</label>
        <textarea name="body" cols="30" rows="10"></textarea>
    </div>
    <div>
        <input type="submit">
    </div>
</form>
</body>
</html>
