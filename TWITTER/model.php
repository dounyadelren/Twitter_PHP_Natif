<?php
session_start();
require_once("bdd.php");

class Users
{
    private $nom;
    private $prenom;
    private $pseudo;
    private $email;
    private $phone;
    private $birth;
    private $mdp_hash;

    public function getInfo()
    {
        return [$this->nom, $this->prenom, $this->pseudo, $this->email, $this->phone, $this->birth, $this->mdp];
    }
    public function setInfo($nom, $prenom, $pseudo, $email, $phone, $birth, $mdp)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->birth = $birth;
        $this->phone = $phone;
        $mdpSalt = 'vive le projet tweet_academy'.$mdp;
        $this->mdp_hash = hash('ripemd160', $mdpSalt);
    }

    public function inscription($bdd)
    {
        if (isset($_POST['submitSubscribe'])) {
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['mail']);
            $phone = htmlspecialchars($_POST['phone']);
            $birth = htmlspecialchars($_POST['birth']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $mdpSalt = 'vive le projet tweet_academy'.$mdp;
            $mdp_hash = hash('ripemd160', $mdpSalt);

            $annee = date('Y');

            list($Y, $M, $D) = explode('-', $birth);

            $Yi = intval($Y);

            $age = $annee - $Yi;

            if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pseudo']) && !empty($_POST['birth']) && !empty($_POST['mail']) && !empty($_POST['phone']) && !empty($_POST['mdp'])) {
                
                if ($age <= 18) {
                    echo "Désolé cette plateforme n'est pas accessible aux mineurs.";
                } else {   
                    $sql = "SELECT * FROM user WHERE email = :mail";
                    $exist = $bdd->prepare($sql);
                    $exist->bindValue(':mail', $email, PDO::PARAM_STR);
                    $exist->execute();
                    if ($exist->fetch()) {
                        echo "Désolé il y a déjà un compte associé à cette adresse email.";
                    } else {
                        $sql = "SELECT * FROM user WHERE phone = :phone";
                        $exist = $bdd->prepare($sql);
                        $exist->bindValue(':phone', $phone, PDO::PARAM_STR);
                        $exist->execute();

                        if ($exist->fetch()) {
                            echo "Désolé il y a déjà un compte associé à ce numéro de téléphone.";
                        } else {                    
                            $sql = "SELECT * FROM user WHERE username = :pseudo";
                            $exist = $bdd->prepare($sql);
                            $exist->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                            $exist->execute();

                            if ($exist->fetch()) {
                                echo "Désolé il y'a déjà un compte associé à ce pseudo.";
                            } else {
                                $insert = "INSERT INTO user(email, phone, password, first_name, last_name, username, birth_date, gender, description, picture, theme) VALUES (:mail, :phone, :mdp, :prenom, :nom, :pseudo, :birth, NULL, NULL, '3kdHTG1', 'Blue')";
                                $requete = $bdd->prepare($insert);
                                $requete->bindValue(':nom', $nom);
                                $requete->bindValue(':prenom', $prenom);
                                $requete->bindValue(':pseudo', $pseudo);
                                $requete->bindValue(':mail', $email);
                                $requete->bindValue(':phone', $phone);
                                $requete->bindValue(':birth', $birth);
                                $requete->bindValue(':mdp', $mdp_hash);
                                $requete->execute();
                                // $req = "SELECT id_user FROM user WHERE email =".$email;
                                // $requete = $bdd->prepare($req);
                                // $requete->execute();
                                // $rep = $requete->fetch(PDO::FETCH_ASSOC);
                                // $insert = "INSERT INTO follow(id_follow, id_user, id_user_follow) VALUES(NULL, ".$rep['id_user'].", ".$rep['id_user'].")";
                                // $requete = $bdd->prepare($insert);
                                // $requete->execute();
                                header('location:connexion.php');
                            }
                        }
                    }   
                }
            }
        }
    }

    public function connect($bdd){
        if(isset($_POST['submitConnect'])){
            $mail = htmlspecialchars($_POST['mail']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $mdpSalt = 'vive le projet tweet_academy'.$mdp;
            $mdp_hash = hash('ripemd160', $mdpSalt);
            if(!empty($mail) && !empty($mdp)){
                $sql = "SELECT email, id_user, first_name, password, last_name, username, phone, picture, gender, description, password FROM user WHERE email = :mail AND password = :mdp";
                $requete = $bdd->prepare($sql);
                $requete->bindValue(":mail", $mail, PDO::PARAM_STR);
                $requete->bindValue(":mdp", $mdp_hash, PDO::PARAM_STR);
                $requete->execute();
                $resultat = $requete->fetch(PDO::FETCH_ASSOC);
                if($resultat) {
                    $_SESSION[':mail'] = $mail;
                    $_SESSION['id_user'] = $resultat['id_user'];
                    $_SESSION['first_name'] = $resultat['first_name'];
                    $_SESSION['password'] = $resultat['password'];
                    $_SESSION['last_name'] = $resultat['last_name'];
                    $_SESSION['username'] = $resultat['username'];
                    $_SESSION['phone'] = $resultat['phone'];
                    $_SESSION['picture'] = $resultat['picture'];
                    $_SESSION['gender'] = $resultat['gender'];
                    $_SESSION['description'] = $resultat['description'];
                    
                    header("Location: twitter.php?page=accueil");
                } else {
                    echo $resultat . "\n Connexion refusée.";
                }
            } else {
                echo "Tout les champs doivent être remplis.";
            }
        }
    }

    public function edit_profile($bdd){
        if(isset($_POST['submit_changes'])){
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $mail = htmlspecialchars($_POST['mail']);
            $phone = htmlspecialchars($_POST['phone']);
            $description = htmlspecialchars($_POST['description']);
            $genre = htmlspecialchars($_POST['genre']);
            $last_mdp = htmlspecialchars($_SESSION['password']);
            $new_mdp = htmlspecialchars($_POST['new_mdp']);
            $confirm_mdp = htmlspecialchars($_POST['confirm_mdp']);
            $new_mdpSalt = 'vive le projet tweet_academy'.$new_mdp;
            $new_mdp_hash = hash('ripemd160', $new_mdpSalt);
            $confirm_mdpSalt = 'vive le projet tweet_academy'.$confirm_mdp;
            $confirm_mdp_hash = hash('ripemd160', $confirm_mdpSalt);
            $id_user = $_SESSION['id_user'];

            if(isset($nom) && !empty($nom)){
                $sql = "UPDATE user SET last_name = :nom WHERE id_user = $id_user";
                $requete = $bdd->prepare($sql);
                $requete->bindValue(':nom', $nom, PDO::PARAM_STR);
                $requete->execute();
                if(!$requete){
                    print_r($requete->errorInfo());
                }
            }

            if(isset($prenom) && !empty($prenom)){
            $sql = "UPDATE user SET first_name = :prenom WHERE id_user = $id_user";
            $requete = $bdd->prepare($sql);
            $requete->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $requete->execute();
            
                if(!$requete){
                    print_r($requete->errorInfo());
                }
            } 

            if(isset($mail) && !empty($mail)){
                $sql = "UPDATE user SET email = :mail WHERE id_user = $id_user";
                $requete = $bdd->prepare($sql);
                $requete->bindValue(':mail', $mail, PDO::PARAM_STR);
                $requete->execute();
                
                    if(!$requete){
                        print_r($requete->errorInfo());
                    }
            }

            if(isset($phone) && !empty($phone)){
                $sql = "UPDATE user SET phone = :phone WHERE id_user = $id_user";
                $requete = $bdd->prepare($sql);
                $requete->bindValue(':phone', $phone, PDO::PARAM_STR);
                $requete->execute();
                
                    if(!$requete){
                        print_r($requete->errorInfo());
                    }
            }

            if(isset($description) && !empty($description)){
                $sql = "UPDATE user SET description = :description WHERE id_user = $id_user";
                $requete = $bdd->prepare($sql);
                $requete->bindValue(':description', $description, PDO::PARAM_STR);
                $requete->execute();
                
                    if(!$requete){
                        print_r($requete->errorInfo());
                    }
            }

            if(isset($genre) && !empty($genre)){
                $sql = "UPDATE user SET gender = :genre WHERE id_user = $id_user";
                $requete = $bdd->prepare($sql);
                $requete->bindValue(':genre', $genre, PDO::PARAM_STR);
                $requete->execute();
                
                    if(!$requete){
                        print_r($requete->errorInfo());
                    }
            }

            if(isset($last_mdp) && isset($new_mdp) && isset($confirm_mdp) && !empty($last_mdp) && !empty($new_mdp) && !empty($confirm_mdp))
            if($last_mdp == $new_mdp_hash){
                echo "Votre ancien mot de passe est trop similaire à votre nouveau mot de passe.";
            } else if ($new_mdp_hash != $confirm_mdp_hash) {
                echo "Veuillez saisir le même mot de passe pour confirmer.";
            } else if ($new_mdp_hash == $confirm_mdp_hash) {
                $sql = "UPDATE user SET password = :new_mdp WHERE id_user = $id_user";
                $requete = $bdd->prepare($sql);
                $requete->bindValue(':new_mdp', $new_mdp_hash, PDO::PARAM_STR);
                $requete->execute();
                echo "Le mot de passe a bien été modifié.";
                if(!$requete){
                    print_r($requete->errorInfo());
                } 
            }     
        }
        header('Location: profil.php');
}
    public function follow($bdd, $idUser, $idUserFollow){
        $req = 'SELECT id_follow FROM follow WHERE id_user ='.$idUser.' AND id_user_follow = '.$idUserFollow;
        $requete = $bdd->prepare($req);
        $requete->execute();
        if($idFollow = $requete->fetch(PDO::FETCH_ASSOC)){
            $req = 'DELETE FROM follow WHERE id_follow = '.$idFollow['id_follow'];
            $requete = $bdd->prepare($req);
            $requete->execute();
        }else{
            $req = 'INSERT INTO follow VALUES(NULL, :id_user, :id_user_follow)';
            $requete = $bdd->prepare($req);
            $requete->bindValue(":id_user", $idUser, PDO::PARAM_INT);
            $requete->bindValue(":id_user_follow", $idUserFollow, PDO::PARAM_INT);
            $requete->execute();
        }
    }

    public function is_follow($bdd, $idUser, $idUserFollow){
        $req = 'SELECT id_follow FROM follow WHERE id_user = '.$idUser.' AND id_user_follow = '.$idUserFollow;
        $requete = $bdd->prepare($req);
        $requete->execute();
        if($requete->fetch()){
            return true;
        }else{
            return false;
        };
    }

    public function get_all_user($bdd){
        $i = 0;
        $req = 'SELECT * FROM user';
        $requete = $bdd->prepare($req);
        $requete->execute();
        while($users[$i] = $requete->fetch(PDO::FETCH_ASSOC)){
            $i++;
        };
        return $users;
    }

    public function get_all_following($bdd, $idUser){
        $i = 0;
        $req = 'SELECT * FROM user INNER JOIN follow ON user.id_user = follow.id_user_follow WHERE follow.id_user = '.$idUser;
        $requete = $bdd->prepare($req);
        $requete->execute();
        while($follow[$i] = $requete->fetch(PDO::FETCH_ASSOC)){
            $i++;
        };
        array_pop($follow);
        return $follow;
    }

    public function get_all_follower($bdd, $idUser){
        $i = 0;
        $req = 'SELECT * FROM user INNER JOIN follow ON user.id_user = follow.id_user WHERE follow.id_user_follow = '.$idUser;
        $requete = $bdd->prepare($req);
        $requete->execute();
        while($follow[$i] = $requete->fetch(PDO::FETCH_ASSOC)){
            $i++;
        };
        array_pop($follow);
        return $follow;
    }

    public function get_nb_following($bdd, $idUser){
        $req = 'SELECT COUNT(DISTINCT user.id_user) AS "nb_following" FROM user INNER JOIN follow ON user.id_user = follow.id_user_follow WHERE follow.id_user = '.$idUser;
        $requete = $bdd->prepare($req);
        $requete->execute();
        $nb_following = $requete->fetch(PDO::FETCH_ASSOC);
        return $nb_following;
    }

    public function get_nb_follower($bdd, $idUser){
        $req = 'SELECT COUNT(DISTINCT user.id_user) AS "nb_follower" FROM user INNER JOIN follow ON user.id_user = follow.id_user WHERE follow.id_user_follow = '.$idUser;
        $requete = $bdd->prepare($req);
        $requete->execute();
        $nb_follower = $requete->fetch(PDO::FETCH_ASSOC);
        return $nb_follower;  
    }

    public function get_id_user_from_tweet($bdd, $idTweet){
        $req = "SELECT id_user FROM user INNER JOIN tweet ON user.id_user = tweet.id_user WHERE id_tweet = ".$idTweet;
        $requete = $bdd->prepare($req);
        $requete->execute();
        $info =  $requete->fetch(PDO::FETCH_ASSOC);
        return $info;
    }
    
    public function get_profil_info($bdd, $idUser){
        $req = 'SELECT picture, last_name, first_name, username, description, gender FROM user WHERE id_user ='.$idUser;
        $requete = $bdd->prepare($req);
        $requete->execute();
        $profil = $requete->fetch(PDO::FETCH_ASSOC);
        return $profil;
    }

    public function search_user($bdd){
            if(isset($_POST['search']) && !empty($_POST['search'])){
                $search = htmlspecialchars($_POST['search']);
                $sql = "SELECT first_name AS 'prenom', last_name AS 'nom', username AS 'username' FROM user  WHERE last_name LIKE '$search%' OR first_name LIKE '$search%' OR username LIKE '$search%'";
                $requete = $bdd->query($sql);
                
                if($requete->rowCount() > 0){
                    while($resultat = $requete->fetch()){
                        ?> <div id="result_search"><?php echo $resultat['prenom'] . " " . $resultat['nom'] . "\n"; echo $resultat['username'] ?><button class='suivre' id='suivre<?php echo $_SESSION['id_user']?>'>follow</button></div><hr>
                        <?php
                    }
                } else {
                    print_r($requete->errorInfo());
                }
            }
    }

    public function generate_random_user($bdd){
        // $id = $_SESSION['id_user'];
        $id = 5;
        $sql = "SELECT id_user AS 'id_user', first_name AS 'prenom', last_name AS 'nom', username AS 'username', picture AS 'picture' FROM user WHERE id_user != '$id' ORDER BY RAND() LIMIT 3";
        $requete = $bdd->prepare($sql);
        $requete->execute();
        if($requete->rowCount() > 0){
            $random = $requete->fetch(PDO::FETCH_NAMED); 
            return $random; 
        }
        
    }
    //METHOD LOGOUT

    public function logout(){
        session_destroy();
        session_unset();
        header('location:connexion.php');
    }
}

class Tweet {
    public function get_last_tweet_content($bdd, $page){
        //$idUser = $_SESSION['id_user'];
        $i = 0;
        if($page == 'explore'){
            $req = 'SELECT * FROM tweet INNER JOIN user ON tweet.id_user = user.id_user ORDER BY tweet.id_tweet DESC';
        }elseif($page == 'accueil'){
            $req = 'SELECT * FROM tweet INNER JOIN user ON tweet.id_user = user.id_user INNER JOIN follow ON follow.id_user_follow = tweet.id_user WHERE follow.id_user = '.$_SESSION['id_user'].' ORDER BY tweet.id_tweet DESC';
        }
        $requete = $bdd->prepare($req);
        $requete->execute();
        while($info[$i] = $requete->fetch(PDO::FETCH_NAMED)){
            $i++;
        };
        array_pop($info);
        return $info;
    }

    public function publish_tweet($bdd){
        $content = htmlspecialchars($_POST['content']);
        $regex = "/#+([\S]+)/";
        $content1 = preg_replace($regex, "<a style='color: #00c2f0' target='blank' href='https://www.google.com/search?q=$1'> $0 </a>", $content); 
        // suite de l'url : ?tag=$1'>$0
        $id = $_SESSION['id_user'];
        if(!empty($content) && !empty($id)){
            $sql = 'INSERT INTO tweet(id_user, content, media_link, created_date) VALUES(:id_user, :content, NULL, CURRENT_TIMESTAMP)';
            $requete = $bdd->prepare($sql);
            $requete->bindValue(":id_user", $id, PDO::PARAM_INT);
            $requete->bindValue(":content", $content1, PDO::PARAM_STR);
            $requete->execute();
            //pour l'insertion des hashtags dans la bdd 
            $content2 = preg_match($regex, $content, $match);
            $req = "INSERT INTO hashtag(name) VALUES('$match[0]')";
            $exec = $bdd->prepare($req);
            $exec->execute();
            if(!$requete){
                print_r($requete->errorInfo());
            } else {
                header("Location: twitter.php?page=accueil");
            }
        }
    }
    
    public function put_in_favoris($bdd, $idUser, $idTweet){

        //On verifie si l'utilisateur a déjà liké ce tweet
        $req = 'SELECT id_favoris FROM favoris WHERE id_tweet ='.$idTweet.' AND id_user = '.$idUser;
        $requete = $bdd->prepare($req);
        $requete->execute();
        if($idFavoris = $requete->fetch(PDO::FETCH_ASSOC)){
            //si c'est le cas on supprime ce like de la db
            $req = 'DELETE FROM favoris WHERE id_favoris = '.$idFavoris['id_favoris'];
            $requete = $bdd->prepare($req);
            $requete->execute();
        }else{
            //Si non on l'ajoute aux favoris
            $req = 'INSERT INTO favoris(id_favoris, id_tweet, id_user) VALUES(NULL, :id_tweet, :id_user)';
            $requete = $bdd->prepare($req);
            $requete->bindValue(':id_tweet', $idTweet);
            $requete->bindValue(':id_user', $idUser);
            $requete->execute();
        }
    }

    public function get_nb_like($bdd, $idTweet){
        //On récupère le nombre de like du tweet
        $req = 'SELECT COUNT(id_favoris) AS "nbFav" FROM favoris WHERE id_tweet ='.$idTweet;
        $requete = $bdd->prepare($req);
        $requete->execute();
        $nbLike = $requete->fetch(PDO::FETCH_ASSOC);
        return $nbLike;
    }

    public function is_liked($bdd, $idTweet, $idUser){
        $req = 'SELECT * FROM favoris WHERE id_tweet = '.$idTweet.' AND id_user = '.$idUser;
        $requete = $bdd->prepare($req);
        $requete->execute();
        if($requete->fetch()){
            return true;
        }else{
            return false;
        };
    }

    public function put_in_retweets($bdd, $idUser, $idTweet){
        $req = 'INSERT INTO retweets(id_tweet, id_user) VALUES(:id_tweet, :id_user)';
        $requete = $bdd->prepare($req);
        $requete->bindValue(':id_tweet', $idTweet);
        $requete->bindValue(':id_user', $idUser);        
        $requete->execute();
        $req = 'SELECT * FROM tweet WHERE id_tweet = '.$idTweet;
        $requete = $bdd->prepare($req);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    // public function retweet_into_content($bdd, $idUser, $tweet, $idUserT){
    //     $req = 'INSERT INTO tweet(content, id_user) VALUES(:content, :id_user)';
    //     $requete = $bdd->prepare($req);
    //     $requete->bindValue(':content', $tweet);
    //     $requete->bindValue(':id_user', $idUser);
    //     $requete->execute();
    // }
}

class Message {

    public function sendDm($bdd) {
        if($_SESSION['id_user']) {
            $id_user = $_SESSION['id_user'];
            if(isset($_POST['pseudo']) && !empty($_POST['pseudo'])){
                if(isset($_POST['dm']) && !empty($_POST['dm'])){
                    $dest = $_POST['pseudo'];
                    $dest = htmlspecialchars($_POST['pseudo']);
                    $sqlDest= "SELECT id_user AS id_dest, username AS username FROM user WHERE username LIKE '$dest%'";
                    $recupeUser = $bdd->query($sqlDest);
                    if($recupeUser->rowCount() > 0){
                        while($destinataire = $recupeUser->fetch(PDO::FETCH_ASSOC)){
                            $id_dest = intval($destinataire['id_dest']);
                        }
                        $message = htmlspecialchars($_POST['dm']);
                        $sql = "INSERT INTO directmessage(content, created_date, id_user, id_dest) VALUES (:dm, CURRENT_TIMESTAMP, :iduser, :iddest)";
                        $send = $bdd->prepare($sql);
                        $send->bindValue(':dm', $message);
                        $send->bindValue(':iduser', $id_user);
                        $send->bindValue(':iddest', $id_dest);
                        $send->execute();
                        // header("location:dm.php");
                        echo " Votre message a été envoyé";
                    } else {
                        echo "Nous n'avons trouvé aucun utilisateurs ou le pseudo n'est pas valide";
                    }
                } else {
                    echo "Veuillez remplir le champ message";
                }
            } else {
                echo "Veuillez renseigner un pseudo";
            }
        }
    }

    public function readDm($bdd) {
        if(isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
            $id_user = $_SESSION['id_user'];
            $sql = "SELECT *, DATE_FORMAT(created_date, 'Message du : %d/%m/%Y') AS created_date FROM directmessage INNER JOIN user WHERE directmessage.id_user = user.id_user ORDER BY created_date";
            $recupDm = $bdd->query($sql);
            if($recupDm->rowCount() > 0){
                while($dm = $recupDm->fetch(PDO::FETCH_ASSOC)){
                    echo $dm['username']?><br><?php
                    echo $dm['content'];?><br><?php
                    echo $dm['created_date'];?><br><br><?php
                }
            }
        }
    }
}

$user = new Users();
$random = $user-> generate_random_user($bdd);
 //var_dump($random);

