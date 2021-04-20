<?php
namespace Lyricorn\User;

use FFI\Exception;
use Lyricorn\System\DbConnect;
use Lyricorn\System\DbCrud;
use PDOException;

class User extends DbCrud
{
    function __construct()
    {
        DbConnect::__construct();
        DbCrud::__construct();
        $this->conn = $this->getConnection();
        return;
    }

    public function insertUser($name, $email,$password)
    {
        try {

            $stmt = $this->conn->prepare('INSERT INTO  tbl_users(userName, email, password) VALUES(:name, :email, :password)');
            $stmt->execute(array(
                ':name'=>$name,
                ':email'=>$email,
                ':password'=>$password
            ));

            return $stmt;

        } catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }

    public function updateUser($name, $id)
    {
        try{

            $stmt = $this->conn->prepare("UPDATE tbl_users SET userName = :name WHERE id = :id");
            $stmt->execute(array(
                ':name'=>$name,
                ':id'=>$id
            ));

            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    public function deleteUser($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_users WHERE id = :id");
            $stmt->execute(array(
                ':id'=>$id
            ));
            return $stmt;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }

    public function readUser()
    {
        
    }
    
}