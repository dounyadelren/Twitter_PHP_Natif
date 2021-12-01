<?php
require_once('model.php');
require_once('head.php');
?>
    <body class="container">
        <!-- <div class="background"> -->
            <!-- <div class="row">
                <div class="five columns"> -->
                    <form class="formulaire" method="POST" action="controler.php">
                    <h1>Inscription</h1>
                        Vos Informations :<br>
                            <input id="nom" type="text" name="nom" placeholder="votre nom" minlength="2" required>
                            <input id="prenom" type="text" name="prenom" placeholder="votre prénom" minlength="2" required>
                            <input id="pseudo" type="text" name="pseudo" placeholder="@" minlength="4" pattern="^@[^\W_]+$" required>
                            <input id="mail" type="email" name="mail" placeholder="exemple@gmail.com" minlength="2" required>
                            <input type="tel" id="phone" name="phone" placeholder="0620202020" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" max=10 required>
                            <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" minlength="8" required> 
                            <label> Date de naissance : </label><input id="date" type="date" name="birth" required><br>
                        <button class="button-primary" name="submitSubscribe" type="submit">S'inscrire</button><br>
                        <a href="connexion.php">Vous avez déjà un compte ?</a>
                    </form>
                <!-- </div>
            </div> -->
                
        <!-- </div> -->
    </body>
</html>