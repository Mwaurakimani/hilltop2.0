<?php
namespace Lyricorn\System;

use PDO;
use PDOException;

class DbConnect
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'post';

    private $conn;
    

    function __construct()
    {
        $connection = $this->connect();
        $this->setConnection($connection);
    }

    /**
     * Create a database connection
     */
    public function connect(){
        
        try{
            //Set Data Source Name
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;

            // create a pdo connection
            $pdo = new PDO($dsn,$this->user,$this->password);

            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            
        }catch(PDOException $exception){
            die("Connection error".$exception->getMessage());
        }

        return $pdo;
    }

    /**
     * get the data base connection
     */
    public function getConnection(){
        return $this->conn;
    }

    /**
     * get the data base connection
     */
    public function setConnection($data){
        $this->conn = $data;
        return;
    }
}