<?php
require_once("model.php");
require_once("head.php");
?>
<body class="container">
    <form id="formulaire_co" action="controler.php" method="POST"><br>
    <h2>Se connecter</h2>
        <label for="mail">Email:</label><br>
        <input type="text" name="mail" id="mail" required/><br>
        <label for="mdp">Mot de passe:</label><br>
        <span id="password" style="display: inline-block"><input type="password" name="mdp" id="mdp" required/><i class="far fa-eye" id="eye" onclick="ShowPassword()" style="visibility: visible; margin-left: 5px;"></i><i class="far fa-eye-slash" id="eye-slash" onclick="ShowPassword()" style="visibility: hidden; margin-left: -18px;"></i></span><br>
        <input type="submit" name="submitConnect" id="submit" class="button-primary" value="connexion"/><br>
        <a href="">Mot de passe oublié?</a><br>
        <a href="inscription.php">Pas encore inscrit?</a>
    </form> 
</body>
</html>