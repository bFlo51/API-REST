<?php

$root = __DIR__ . '/..';
$autoload = "$root/vendor/autoload.php";
error_log ("loading autoload : $autoload");
require $autoload;


include 'config.php';
$app = new Slim\App(["settings" => $config]);
//Handle Dependencies
$container = $app->getContainer();

$container['db'] = function ($c) {
   
   try{
       $db = $c['settings']['db'];
       $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE                      => PDO::FETCH_ASSOC,
       );
       $pdo = new PDO("mysql:host=" . $db['servername'] . ";dbname=" . $db['dbname'],
       $db['username'], $db['password'],$options);
       error_log("CONNECTED YEY ;) ");
       return $pdo;
   }
   catch(\Exception $ex){
        error_log("CONNECTION KO :( ");
       return $ex->getMessage();
   }
   
};



try{
    $db = $c['settings']['db'];
    $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE                      => PDO::FETCH_ASSOC,
    );
    $pdo = new PDO("mysql:host=" . $db['servername'] . ";dbname=" . $db['dbname'],
    $db['username'], $db['password'],$options);
    error_log("CONNECTED YEY ;) ");
    return $pdo;
}
catch(\Exception $ex){
     error_log("CONNECTION KO :( ");
     error_log($ex->getMessage());
    return $ex->getMessage();
}