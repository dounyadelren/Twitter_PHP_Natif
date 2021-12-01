<?php
include("head.php");
require("controler.php");
// session_start();
if(!$_SESSION[':mail']){
    header("location:connexion.php");
}
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
            <?php $_SESSION['page'] = $_GET['page'] ?>

            <!-- button de déconnexion -->
            <form method="POST" action="controler.php">
                <button type="submit" name="submitLogout">Déconnexion</button>
            </form>
            <img class="profilPic_nav" src="https://www.bit.ly/<?php echo $_SESSION['picture'];?>"/>
            <?php 
                echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "<br>";
                // var_dump($_SESSION);
            ?>
                <div id="username_nav"><?php echo $_SESSION['username'];?></div>
            
            <br>
        </div>

        <!----espace pour tweeter---->
            <div class="seven columns middle">
                <h3><b>Accueil</b></h3>
                <hr>
                <form action="controler.php" method="POST">
                <img class="profilPic" src="https://www.bit.ly/<?php echo $_SESSION['picture'];?>"/><textarea class="mention" name="content" spellcheck="true" wrap id="input_tweet" style="margin-left: 50px; margin-top: -50px" maxlength="140" placeholder="Quoi de neuf ?"></textarea>
                    <hr id="hr_timeline">
                     <input type="file" name="file" id="input_file" style="display: none" accept="image/png, image/jpeg" multiple>
                     <label for="input_file"><img class="media_link" src="./assets_twitter/image_icon.png"></label>
                     <button class="button-primary" id="btn_tweeter" name="publier">Tweeter</button>
                </form>
                <hr>
                <div id="result_search"></div>
                <div id="timeline">
                    <!-- ici il y aura le fil d'actualité -->
                </div>
            </div>

        <!---espace de droite recherches--->
        <div class="four columns footer">
            <form method="POST" action="controler.php">
                <input type="search" placeholder="Rechercher sur Twitter" id="recherche" style="width:50%"><button type="submit" name="submit_search" id="submit_search" class="button-primary" style="border-radius: 10px; margin-left: 10px;padding-right: 10px; padding-left: 10px">GO</button>

                <div class="bloc_un">
                    <p>Vous connaissez peut-être</p>
                    <?php echo "<a href='profil.php?page=profil&id_user=" . $random['id_user'] . "&page=profil'><img  style='widht: 50px; height: 50px; border-radius: 50%; vertical-align:middle;margin-right: 10px' src='https://www.bit.ly/" . $random['picture'] . "'/>" . $random['prenom'] . " " . $random['nom'] . "</a>";?>
                </div>
                <br>
                <div class="bloc_deux">
                    <img alt="erreur de chargement" style="width: 50%; height: 90%;"src="/assets_twitter/pub.jpg"/>
                </div>
            <form>
        </div>
    </div> 
<script src="theme.js"></script> 
</body>

</html>