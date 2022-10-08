<!DOCTYPE html>
<html>
<head>
    <title>SupLink - Register Page</title>
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
    <legend>Register</legend>
<form id="formulaire" enctype="multipart/form-data" method="POST">
    <br><label for="usernameLabel">Nom d'utilisateur: </label><br>
    <input type="text" name="name" class="marge" placeholder="Votre nom d'utilisateur" id="usernameLabel"><br>

    <label for="emailLabel">Email: </label><br>
    <input type="text" name="email" class="marge" placeholder="Votre email" id="emailLabel"><br>

    <label for="PasswordLabel">Mot de passe: </label><br>
    <input type="password" name="motDePasse" class="marge" placeholder="Votre mot de passe" id="PasswordLabel"><br>

    <label for="confirmationLabel">Confirmation: </label><br>
    <input type="password" name="confirmation" class="marge" placeholder="Votre mot de passe" id="confirmationLabel"><br><br>

    <input type="submit" name="envoyer" value="Confirmation"/>
</form>
</fieldset>

<br>
<p style="text-align:center"><a href="quit.php">Si vous possedez deja un compte</a></p>
<br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=suplink', 'root', '');

if(isset($_POST['envoyer'])){
    $username = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = sha1($_POST['motDePasse']);
    $confirmation = sha1($_POST['confirmation']);

    if(!empty($_POST['name']) AND !empty($_POST['email']) AND !empty($_POST['motDePasse']) AND !empty($_POST['confirmation'])){

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            if($password == $confirmation){
                $inscriptionUtilisateur = $bdd->prepare("INSERT INTO membres(id, mdp, mail) VALUES(?,?,?)");
                $inscriptionUtilisateur->execute("'array($username, $email, $password)'");
            }
            else {
                $messageErreur = "Le mot de passe n'est pas bon";
                echo "<p style='color:red;font-size:30px;'>" . $messageErreur . "</p>";
            }
        }
        else{
            $messageErreur = "L'adresse Email n'est pas valide";
            echo "<p style='color:red;font-size:30px;'>" . $messageErreur . "</p>";
        }
    }
    else{
        $messageErreur = "Il faut tout remplir";
        echo "<p style='color:red;font-size:30px;'>" . $messageErreur . "</p>";
    }
}

?>
<footer>
    <p>2018 SupLink - A project developped by id:225107 with <a href="https://www.supinfo.com/">SUPINFO International
            University</a>.</p>
</footer>
</body>
</html>