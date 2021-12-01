<?php
// include("bdd.php");
include("head.php");
session_start();
if(!$_SESSION[':mail']){
    header("location:connexion.php");
}
?>

<body class="container"> 
    <div class="row">
        <!---barre de nav--->
        <div class="nav three columns">
            <ul>
                <li><a href=""><img class="flex" src="./assets_twitter/twitter.png"></a></li>
                <div class="icon">
                    <li style="margin-top: 25px"><a href= "twitter.php?page=accueil"><img class="flex" src="./assets_twitter/home.png">Accueil</a></li>
                    <li style="margin-top: 25px"><a href= "twitter.php?page=explore"><img class="flex" src="./assets_twitter/hashtag.png">Explorer</a></li>
                    <li style="margin-top: 25px"><a href= "" ><img class="flex"  src="./assets_twitter/notif_2.png">Notifications</a></li>
                    <li style="margin-top: 25px"><a href= "dm.php" ><img class="flex" src="./assets_twitter/messages.png">Messages</a></li>
                    <li style="margin-top: 25px"><a href= "" ><img class="flex" src="./assets_twitter/bookmark.png">Signets</a></li>
                    <li style="margin-top: 25px"><a href= "" ><img class="flex" src="./assets_twitter/list.png">Listes</a></li>
                    <li style="margin-top: 25px"><a href= "profil.php?page=profil&id_user=<?php echo $_SESSION['id_user']?>"><img class="flex" src="./assets_twitter/profile.png">Profil</a></li>
                    <li style="margin-top: 25px"><a href= "#" ><img class="flex" src="./assets_twitter/more.png">Plus</a></li>
                </div>
            </ul>
            <?php $_SESSION['page'] = $_GET['page'] ?>
            <!-- <a href="dm.php">dm</a> -->

            <!-- button de déconnexion -->
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
            <h3><b>Messages</b><i style="float: right; cursor: pointer;" id="pen"class="fas fa-pen-alt"></i></h3>
            <hr>
            <form id="write_dm" style="display: none"method="POST" action="controler.php">
                <input type="text" name="pseudo" required><br>
                <textarea name="dm" id="input_dm"></textarea required><br>
                <button type="submit" class="button-primary" name="send_dm">Envoyer</button>
            </form>
        </div>
        <div class="four columns footer">
            <div class="conv">
                <!--- CONVERSATIONS---->
            </div>
        </div>
<script src="theme.js"></script>
</body>
</html>