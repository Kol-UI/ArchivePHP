<?php

session_start();

require_once __DIR__ . '/../src/Manager/Pdo/PdoUserManager.php';
require_once __DIR__ . '/../src/Manager/Pdo/PdoPostManager.php';

$user_manager = new PdoUserManager();
$post_manager = new PdoPostManager();


if ($user_manager->getUser() == null) {
	header('Location: login.php');
}

$post_list = $post_manager->findAll();

?>


<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
    <a href="add.php">Ajouter un post</a>
    <a href="logout.php">Logout</a>
    <h1>Ma liste</h1>
    <div>
	    <?php
        /** @var Post $post */
	    foreach($post_list as $post): ?>
            <div style="background: rgba(0,0,0,0.15); margin: 10px 5px;">
                <b><?php echo $post->getTitle() ?></b>
                <p><?php echo $post->getBody() ?></p>
                <a href="remove.php?id=<?php echo $post->getId(); ?>">Supprimer</a>
                <?php
                /** @var Comment $comment */
                foreach ($post->getCommentList() as $comment): ?>
                <div style="background: white; margin: 1px 15px">
                    <b><?php echo $comment->getUser()->getFirstname() ?></b>
                    <p><?php echo $comment->getContent() ?></p>
                </div>
                <?php endforeach; ?>
                <form action="comment_add.php?id=<?php echo $post->getId(); ?>" method="post">
                    <input type="text" name="content">
                    <input type="submit">
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
