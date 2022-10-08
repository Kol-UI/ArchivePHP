<!DOCTYPE html>
<html>
<head>
    <title>SupLink - Dashboard</title>

</head>
<style>
    #titre {
        text-align: center;
        font-size: 300%;
    }
    .marge {
        margin-left: 30px;
    }
</style>
<body>

<p id="titre">SupLink - Another Url Shortener</p>

<fieldset>
    <legend>New URL</legend>
    <form id="formulaire" enctype="multipart/form-data" action="Raccourcis.php" method="POST">
        <label for="urlLabel">URL: </label>
        <input type="url" name="url" class="marge" placeholder="The URL" autocomplete="off">
        <input type="submit" name="envoyer" value="Generate" />
    </form>
</fieldset>

<br>
<p style="text-align:right"><a href="quit.php">Déconnexion</a></p>

<footer>
    <p>2018 SupLink - A project developped by id:225107 with <a href="https://www.supinfo.com/">SUPINFO International
            University</a>.</p>
</footer>

<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=suplink', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0){
    $idConnexion = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($idConnexion));
    $informations = $requser->fetch();
}
?>
</body>
</html>