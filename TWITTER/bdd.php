<?php

// UNIQUEMENT POUR CORENTIN
// require_once("./vendor/autoload.php");
// use \Dotenv\Dotenv;
// $dotenv = Dotenv::createImmutable(__DIR__);
// $dotenv->load();

if(!empty($_ENV['SQLUSER']) && !empty($_ENV['SQLPASS'])){
    $SQLUSER = $_ENV['SQLUSER'];
    $SQLPASS = $_ENV['SQLPASS'];
    
} else{
    $SQLUSER = getenv('SQLUSER');
    $SQLPASS = getenv('SQLPASS');
}

try{
$bdd = new PDO("mysql:host=localhost:8889;dbname=tweet_academie", $SQLUSER, $SQLPASS);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage();
    die();
}
?>