<?php
include("head.php");
require_once("controler.php");
require_once("model.php");
//session_start();
if(!$_SESSION[':mail']){
    header("location:connexion.php");
}
$_SESSION['id_user_profil'] = $_GET['id_user'];
?>
<body class="container"> 
    <div class="row">
        <!---barre de nav--->
        <div class="nav three columns">
            <ul>
                <li><a href="twitter.php?page=accueil"><img class="flex" src="./assets_twitter/twitter.png"></a></li>
                <div class="icon">
                    <li style="margin-top: 25px"><a href= "twitter.php?page=accueil"><img class="flex" src="./assets_twitter/home.png">Accueil</a></li>
                    <li style="margin-top: 25px"><a href= "twitter.php?page=explore"><img class="flex" src="./assets_twitter/hashtag.png">Explorer</a></li>
                    <li style="margin-top: 25px"><a href= "" ><img class="flex"  src="./assets_twitter/notif_2.png">Notifications</a></li>
                    <li style="margin-top: 25px"><a href= "dm.php" ><img class="flex" src="./assets_twitter/messages.png">Messages</a></li>
                    <li style="margin-top: 25px"><a href= "" ><img class="flex" src="./assets_twitter/bookmark.png">Signets</a></li>
                    <li style="margin-top: 25px"><a href= "" ><img class="flex" src="./assets_twitter/list.png">Listes</a></li>
                    <li style="margin-top: 25px"><a href= "profil.php?page=profil&id_user=<?php echo $_SESSION['id_user']?>" ><img class="flex" src="./assets_twitter/profile.png">Profil</a></li>
                    <li style="margin-top: 25px"><a href= "" ><img class="flex" src="./assets_twitter/more.png">Plus</a></li>
                </div>
            </ul>
            <?php $_SESSION['page'] = $_GET['page'];
            ?>

            <form method="POST" action="controler.php">
                <button type="submit" name="submitLogout">Déconnexion</button>
            </form>
            <img class="profilPic_nav" src="https://www.bit.ly/<?php echo $_SESSION['picture'];?>"/>
            <?php 
                echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "<br>";
            ?>
                <div id="username_nav"><?php echo $_SESSION['username'];?></div>
            
            <br>
        </div>
        <div class="seven columns middle">
            <h3><b>Profil</b></h3>
            <div id="div_profilPic"></div><br>
            <strong><h5 id='nomProfil'></h5></strong>
            <p id='usernameProfil'></p>
            <hr>
            <?php 
            if(isset($_GET['id_user'])){
                //$user = New Users();
                $info = $user->get_profil_info($bdd, $_GET['id_user']);
            }
            
            ?>
            <label id="labelGenre">Genre:</label><p id="genreProfil"><?php echo $info['gender']?></p>
            <hr>
            <label id="labelDescription">Description:</label><p id="descriptionProfil"><?php echo $info['description']?></p>
            <br>
            <p id="nbFollow"></p>
            <hr>    
            <?php if($_GET['id_user'] == $_SESSION['id_user']){?>
            <button id="modifierProfil">Modifier le profil</button>
            <form method="POST" action="controler.php" style='display:none' id="formModifProfil">
                <label id="prenom">Prénom:</label><input id="input_prenom" type="text"  name="prenom" disabled value="<?php echo $_SESSION['first_name']?>"/><i id="edit_prenom"class="far fa-edit"></i>
                <label id="nom">Nom:</label><input id="input_nom" type="text" name="nom" disabled value="<?php echo $_SESSION['last_name']?>"/><i id="edit_nom" class="far fa-edit"></i>
                <label id="nom">Username</label><input type="text" disabled value="<?php echo $_SESSION['username']?>"/>
                <label id="mail">Mail:</label><input id="input_mail" type="text" name="mail" disabled value="<?php echo $_SESSION[':mail']?>"/><i id="edit_mail" class="far fa-edit"></i>
                <label id="tel">Numéro de téléphone:</label><input id="input_phone" type="text" name="phone" disabled value="<?php echo $_SESSION['phone']?>"/><i id="edit_phone" class="far fa-edit"></i><br>
                <label id="description">Description:</label><textarea id="input_descri" type="text" name="description" disabled value="<?php echo $_SESSION['description']?>"/><?php echo $_SESSION['description']?></textarea><i id="edit_descri" class="far fa-edit"></i>
                <label id="genre">Genre:</label><select name="genre" id="genre">
                    <option value="Femme">Femme</option>
                    <option value="Homme">Homme</option>
                    <option value="ND">Non binaire</option>
                    <option value="GF">Gender Fluid</option>
                </select><br>
                <button id="modif_mdp">Modifier le mot de passe</button><br>
                <div id="set_mdp"></div>
                <button id="valider" name="submit_changes" class="button-primary" style="justify-content: center">Valider les modifications</button>
                <label for="theme">Choisissez un thème : 
                    <select name="theme" id="theme">
                        <option value="1" id="light">Clair</option>
                        <option value="2" id="blue">Bleu</option>
                        <option value="3" id="black">Sombre</option>
                        <option value="5" id="pink">Rose</option>
                    </select>
                </label>
            </form>
            <?php }; ?>
            <h5>Suivis</h5>
            <div id='following'></div>
            <h5>Followers</h5>    
            <div id='follower'></div>           
        </div>
        <div class="four columns footer">
            <form method="POST" action="controler.php">
                <input type="search" placeholder="Rechercher sur Twitter" id="recherche" style="width:50%"><button type="submit" name="submit_search" id="submit_search" class="button-primary" style="border-radius: 10px; margin-left: 10px;padding-right: 10px; padding-left: 10px">GO</button>
            
                <div class="bloc_un">
                    <p>Vous connaissez peut-être</p>
                    <?php echo "<a href='profil.php?page=profil&id_user=" . $random['id_user'] . "&page=profil'><img  style='widht: 50px; height: 50px; border-radius: 50%; vertical-align:middle;margin-right: 10px' src='https://www.bit.ly/" . $random['picture'] . "'/>" . $random['prenom'] . " " . $random['nom'] . "</a>";?>
                </div>
                <br>
                <div class="bloc_deux">
                    <img alt="erreur de chargement"src="/assets_twitter/pub2.jpg"/>
                </div>
            </form>
        </div>
    <script src="theme.js"></script>
</body>