<?php
require '../vendor/autoload.php';
include 'config.php';
$app = new Slim\App(["settings" => $config]);
//Handle Dependencies
$container = $app->getContainer();

$container['db'] = function ($c) {
   
   try{
       $db = $c['settings']['db'];
       $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       					 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       );
       $pdo = new PDO("mysql:host=" . $db['servername'] 
       					. ";port=" . $db['port']. ";dbname=" . $db['dbname'],
       $db['username'], $db['password'],$options);
       return $pdo;
   }
   catch(\Exception $ex){
   	error_log("Erreur PDO " . $ex->getMessage());
       return $ex->getMessage();
   }
   
};

$app->post('/personnage', function ($request, $response) {
   
   try{
       $con = $this->db;
       $sql = "INSERT INTO `personnage`(`nom`, `niveau`,`classe`) VALUES (:nom,:niveau,:classe)";
       //error_log("AAA" . $con . "KO :(");
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':nom' => $request->getParam('nom'),
       ':niveau' => $request->getParam('niveau'),
       ':classe' => $request->getParam('classe'),
       );
       $result = $pre->execute($values);
       return $response->withJson(array('status' => 'Personnage Created'),200);
       
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

$app->get('/personnage/{id}', function ($request,$response) {
   try{
       $id     = $request->getAttribute('id');
       $con = $this->db;
       $sql = "SELECT * FROM personnage WHERE id = :id";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':id' => $id);
       $pre->execute($values);
       $result = $pre->fetch();
       if($result){
           return $response->withJson(array('status' => 'true','result'=> $result),200);
       }else{
           return $response->withJson(array('status' => 'Personnage Not Found'),422);
       }
      
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

$app->get('/personnages', function ($request,$response) {
   try{
       $con = $this->db;
       $sql = "SELECT * FROM personnage";
       $result = null;
       foreach ($con->query($sql) as $row) {
           $result[] = $row;
       }
       if($result){
           return $response->withJson(array('status' => 'true','result'=>$result),200);
       }else{
           return $response->withJson(array('status' => 'Personnages Not Found'),422);
       }
              
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

$app->put('/personnage/{id}', function ($request,$response) {
   try{
       $id     = $request->getAttribute('id');
       $con = $this->db;
       $sql = "UPDATE personnage SET nom=:nom,classe=:classe,niveau=:niveau WHERE id = :id";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':nom' => $request->getParam('nom'),
       ':classe' => $request->getParam('classe'),
       ':niveau' => $request->getParam('niveau'),
       ':id' => $id
       );
       $result =  $pre->execute($values);
       if($result){
           return $response->withJson(array('status' => 'Personnage Updated'),200);
       }else{
           return $response->withJson(array('status' => 'Personnage Not Found'),422);
       }
              
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

$app->delete('/personnage/{id}', function ($request,$response) {
   try{
       $id     = $request->getAttribute('id');
       $con = $this->db;
       $sql = "DELETE FROM personnage WHERE id = :id";
       $pre  = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
       ':id' => $id);
       $result = $pre->execute($values);
       if($result){
           return $response->withJson(array('status' => 'Personnage Deleted'),200);
       }else{
           return $response->withJson(array('status' => 'Personnage Not Found'),422);
       }
      
   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
   
});

$app->run();
