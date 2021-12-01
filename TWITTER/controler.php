<?php
//session_start();
require_once('bdd.php');
require_once('model.php');


if(isset($_POST['retweet'])){
    $tweet = New Tweet();
    
    
}
if(isset($_POST['retweet'])){
    $tweet = New Tweet();
    $user = New User();
    $tab = $tweet->put_in_retweets($bdd, $_SESSION['id_user'], $_POST['id_tweet']);
    $id = $user->get_id_user_from_tweet($bdd, $_POST['id_tweet']);
    $info = $user->get_profil_info($bdd, $id['id_user']);
    $tweet->retweet_into_content($bdd, $_SESSION['id_user'], $_POST['content']);
    $_SESSION['id_user_last_retweet'] = $_POST['id_user_tweet'];
    array_unshift($tab, $info);
    echo json_encode($tab);
}

$tweet = New Tweet();
if(isset($_POST['publier'])){
    $publier = $tweet->publish_tweet($bdd);
}

if(isset($_POST['submitSubscribe'])){
    $user = new Users(':nom', ':prenom', ':pseudo', ':mail', ':phone', ':birth', ':mdp');
    $user->inscription($bdd);
}

if(isset($_POST['submitConnect'])){
    $user = new Users(':mail', ':mdp');
    $user->connect($bdd); 
}

if(isset($_POST['submit_search'])){
    $user = new Users();
    if($_SESSION['page'] = 'profil' || $_SESSION['page'] = 'explore' || $_SESSION['page'] = 'accueil'){
    $result = $user->search_user($bdd);
    echo json_encode($result);
    }
}

if(isset($_POST['submitLogout'])){
    $user = new Users();
    $user->logout();
}
if(isset($_POST['submit_changes'])){
    $user = new Users();
    $modifier = $user->edit_profile($bdd);
}

if(isset($_POST['refresh'])){
    $tweet = New Tweet();
    $user = new Users();
    if($_SESSION['page'] == 'profil'){
        $users = [];
        $following = $user->get_all_following($bdd, $_SESSION['id_user_profil']);
        $follower = $user->get_all_follower($bdd, $_SESSION['id_user_profil']);
        $nbFollowing = $user->get_nb_following($bdd, $_SESSION['id_user_profil']);
        $nbFollower = $user->get_nb_follower($bdd, $_SESSION['id_user_profil']);
        $infoProfil = $user->get_profil_info($bdd, $_SESSION['id_user_profil']);
        $isFollow = $user->is_follow($bdd, $_SESSION['id_user'], $_SESSION['id_user_profil']);
        $_SESSION['nbFollowing'] = $nbFollowing['nb_following'];
        $_SESSION['nbFollower'] = $nbFollower['nb_follower'];
        array_unshift($users, $isFollow);
        array_unshift($users, $infoProfil);
        array_unshift($users, $following);
        array_unshift($users, $follower);
        array_unshift($users, $_SESSION);
        echo json_encode($users);
        
    }elseif($_SESSION['page'] == 'accueil' || $_SESSION['page'] == 'explore'){
        $infos = $tweet->get_last_tweet_content($bdd, $_SESSION['page']);
        foreach($infos as $info){
            foreach($info as $key => $value){
                if($key == 'id_tweet'){
                    $nbLike[$value] = $tweet->get_nb_like($bdd, $value);
                    $isLiked[$value] = $tweet->is_liked($bdd, $value, $_SESSION['id_user']);
                }elseif($key == 'id_user'){
                    if($_SESSION['page'] == 'accueil'){
                        $isFollow[$value[1]] = $user->is_follow($bdd, $_SESSION['id_user'], $value[1]);
                    }else{
                        $isFollow[$value[0]] = $user->is_follow($bdd, $_SESSION['id_user'], $value[0]);
                    }
                }
            }
        }
        $users = $user->get_all_user($bdd);
        array_unshift($infos, $isLiked);
        array_unshift($infos, $isFollow);
        array_unshift($infos, $nbLike);
        array_unshift($infos, $users);
        array_unshift($infos, $_SESSION);
        echo json_encode($infos);
    }
}

if(isset($_POST['like'])){
    $tweet = New Tweet();
    $nbLike = $tweet->put_in_favoris($bdd, $_SESSION['id_user'], $_POST['id_tweet']);
}

if(isset($_POST['follow'])){
    $user = New Users();
    $user->follow($bdd, $_SESSION['id_user'], $_POST['id_user_follow']);
    $tweet = New Tweet();
}

if(isset($_POST['send_dm'])){
    $message = New Message();
    $message->sendDm($bdd);
}

if(isset($_POST['read_dm'])){
    $message = New Message();
    $message->readDm($bdd);
}

$user = new Users();
$user->generate_random_user($bdd);
