<!DOCTYPE html>
<html>
<head>
    <title>SupLink - Login Page</title>
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
<a href="https://www.supinfo.com/"><img src="supinfo-logo.jpg" alt="supinfoLogo" style="float:left;width:50px;height:50px;"></a>
<a href="https://www.supinfo.com/"><img src="supinfo-logo.jpg" alt="supinfoLogo" style="float:right;width:50px;height:50px;"></a>
<p id="titre">SupLink - Another Url Shortener</p>

<fieldset>
    <legend>Login</legend>
    <form id="formulaireCo" enctype="multipart/form-data" method="POST">
        <br><label for="usernameLabel">Nom d'utilisateur: </label><br>
        <input type="text" name="usernameCo" class="marge" placeholder="Votre nom d'utilisateur" id="usernameLabel"><br>

        <label for="PasswordLabel">Mot de passe: </label><br>
        <input type="password" name="motDePasseConnexion" class="marge" placeholder="Votre mot de passe" id="PasswordLabel"><br><br>

        <input type="submit" name="envoyerConnexion" value="Connexion"/>
    </form>
</fieldset>


<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=suplink', 'root', '');
if(isset($_POST['envoyerConnexion'])){
    $connexionUsername = htmlspecialchars($_POST['usernameCo']);
    $connexionMotDePasse = sha1($_POST['motDePasseConnexion']);
    if(!empty($connexionUsername) AND !empty($connexionMotDePasse)){
        $requete = $bdd->prepare("SELECT * FROM membres WHERE id = ? AND mdp = ?");
        $requete->execute(array($connexionUsername, $connexionMotDePasse));
        $testUtilisateur = $requete->rowCount();
        if($testUtilisateur == 1){ //Si un utilisateur avec ce nom existe alors
            $infoSession = $requete->fetch();
            $_SESSION['id'] = $infoSession['username'];
            $_SESSION['email'] = $infoSession['mail'];
            header("Location: FormulaireSupLink.php?id=".$_SESSION['id']);
        }
        else{
            $messageMauvaiseConnexion = "Un champs de connexion est mal rempli.";
            echo $messageMauvaiseConnexion;
        }
    }
    else{
        $messageMauvaiseConnexion = "il faut tout remplir pour se connecter.";
        echo $messageMauvaiseConnexion;
    }
}

?>

<footer>
    <p>2018 SupLink - A project developped by id:225107 with <a href="https://www.supinfo.com/">SUPINFO International
            University</a>.</p>
</footer>

</body>
</html>