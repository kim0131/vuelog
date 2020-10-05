<?php

use Slim\Exception\NotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;




require __DIR__ . '/../../vendor/autoload.php';


class funbook
{

    public function read(Request $request, Response $reponse)
    {
        $sql = "SELECT * FROM BOOKSHELF";

        try {

            $db = new db();
            $pdo = $db->pdo;

            $stmt = $pdo->query($sql);
            $books = $stmt->fetchAll(PDO::FETCH_OBJ);

            $pdo = null;
            echo json_encode($books, JSON_UNESCAPED_UNICODE);
        } catch (\PDOException $e) {
            echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
        }
    }

    public function reada(Request $request, Response $reponse, array $args)
    {
        $id = $request->getAttribute('id');

        $sql = "SELECT * FROM BOOKSHELF where id = $id";

        try {
            $db = new db();
            $pdo = $db->pdo;

            $stmt = $pdo->query($sql);
            $user = $stmt->fetchAll(PDO::FETCH_OBJ);

            $pdo = null;


            echo json_encode($user, JSON_UNESCAPED_UNICODE);
        } catch (\PDOException $e) {
            echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
        }
    }


    //make a post request
    public function add(Request $request, Response $reponse, array $args)
    {
        $title = $request->getParam('title');
        $author = $request->getParam('author');
        $price = $request->getParam('price');
        $category = $request->getParam('category');
        $created = date("Y-m-d H:i:s");

        try {
            //get db object
            $db = new db();
            //conncect
            $pdo = $db->pdo;


            $sql = "INSERT INTO BOOKSHELF (title, author, category, price, created) VALUES (?,?,?,?,?)";


            $pdo->prepare($sql)->execute([$title, $author, $category, $price, $created]);
            $pdo = null;
            echo '' . $title . '저장 완료';
        } catch (\PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}}';
        }
    }

    //make a post request
    public function update(Request $request, Response $reponse, array $args)
    {
        $id = $request->getAttribute('id');
        $title = $request->getParam('title');
        $author = $request->getParam('author');
        $price = $request->getParam('price');
        $category = $request->getParam('category');
        $created = date("Y-m-d H:i:s");

        try {
            //get db object
            $db = new db();
            //conncect
            $pdo = $db->pdo;


            $sql = "UPDATE BOOKSHELF SET title =?, author=?, category=?, price=?,created=? WHERE id=?";


            $pdo->prepare($sql)->execute([$title, $author, $category, $price, $created, $id]);


            $pdo = null;
            echo '{' . $id . '수정 성공}';
        } catch (\PDOException $e) {

            echo '{"error": {"text": ' . $e->getMessage() . '}}';
        }
    }


    public function delete(Request $request, Response $reponse, array $args)
    {
        $id = $request->getAttribute('id');

        try {
            //get db object
            $db = new db();
            //conncect
            $pdo = $db->pdo;

            $sql = "DELETE FROM BOOKSHELF WHERE id=?";

            $pdo->prepare($sql)->execute([$id]);
            $pdo = null;

            echo '{' . $id . '번 삭제}';
        } catch (\PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}}';

        }
    }
    public function selectdel(Request $request, Response $reponse, array $args)
    {
            // $userIds = $request->getAttribute('userIds');
            $body = $request->getParsedBody();
            // echo $body["userIds"][0];
            $array_id = $body["userIds"];

            /* , 을 기준으로 나누어 배열은 만든다 */
            //  $array_id = explode(',', $id);

            $idcnt = count($array_id);
            try {
                //get db object
                $db = new db();
                //conncect
                $pdo = $db->pdo;

                $sql = "DELETE FROM BOOKSHELF WHERE id=?";

                // foreach ($array_id as $k => $v) {
                //     $pdo->prepare($sql)->execute([$v]);
                // }

                for ($i = 0; $i < $idcnt; $i++) {
                    $pdo->prepare($sql)->execute([$array_id[$i]]);
            //             // array(

            //             // $id => $array_id[$i]

            //             // )
            //         // );
                }
                $pdo = null;
               

                echo '{' . implode(",", $array_id) . '번 삭제}';
                } catch (\PDOException $e) {
                    echo '{"error": {"text": ' . $e->getMessage() . '}}';
                } 

    }



    public function gettoken(Request $request, Response $reponse, array $args)
    {
        $token = $request->getParam('token');

        
        try {
            //get db object
            $db = new db();
            //conncect
            $pdo = $db->pdo;

            $sql = "INSERT INTO token (token) VALUES (?)";

            $pdo->prepare($sql)->execute([$token]);
            $pdo = null;

            echo '{' . $token . '저장 완료}';
        } catch (\PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}}';
            
        }
    }



}
