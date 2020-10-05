<?php
/*
class db
{

    public function connect()
    {
        $host = "49.50.175.144";
        $user = "high";
        $pass = "high0";
        $dbname = "SHOPPING";

        //connect database using php pdo wrapper 
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}

*/
class db
{

    var $serverName = "49.50.175.144"; // localhost
    var $port = "3306";
    var $dbName = "SHOPPING";
    var $username = "high";
    var $pass = "high0";

    var $pdo = null;

    function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        if (is_null($this->pdo)) {
            try {
                // if (PHP_OS == "Linux") {
                //     $pdo = new PDO('dblib:host=' . $this->serverName . ':' . $this->port . '; dbname=' . $this->dbName . '; TDS_Version=7.4; ClientCharset=EUC-KR', $this->username, $this->pass);
                // } else {
                $pdo = new PDO(sprintf("mysql:host=%s;port=%s;dbname=%s;charset=utf8", $this->serverName, $this->port, $this->dbName), $this->username, $this->pass);
                // }

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
                if (!$pdo) {
                    die("DB 연결 실패");
                }
            } catch (PDOException $e) {
                $e->getMessage();
            }
            return $pdo;
        }
    }
}
