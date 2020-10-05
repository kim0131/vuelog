<?php

use Slim\Exception\NotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


use Firebase\JWT\JWT;

require __DIR__ . '/../../vendor/autoload.php';


class func{




public function login(Request $request, Response $reponse) {
    $userid = $request->getParam('id');
    $password = $request->getParam('password');


    $sql = "SELECT * FROM VueLogin WHERE USERID = '$userid' AND PASSWORD = '$password'";



    try {

        $db = new db();
        $pdo = $db->pdo;

        $stmt = $pdo->query($sql);
        $login = $stmt->fetchAll(PDO::FETCH_OBJ);

            
        $pdo = null;

        $size = sizeof($login);

            if ($size > 0) {
         
            // echo json_encode($login);
            $result = (array) $login[0];
            
            $key = $userid;
            $payload = array(
                'data' =>[
                    "username" => "$userid",                    
                    "group" => $result["GROUP"]
                ]
            );

            // echo json_encode($payload);


            $jwt = JWT::encode($payload, $key);
            $decoded = JWT::decode($jwt, $key, array('HS256'));



            $decoded_array = (array) $decoded;


            JWT::$leeway = 60; // $leeway in seconds
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            $return = array(
                'token' => $jwt
            );

            echo json_encode($return);
               

            }
            else{
                throw new PDOException('0');
            }
     

            
           
   
    } catch (\PDOException $e) {
        
        
        // echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
       
    }
}


}


