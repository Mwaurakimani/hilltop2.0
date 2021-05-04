<?php
namespace Lyricorn\User;

use Lyricorn\System\DbCrud;
use PDOException;

class User extends DbCrud
{
    function __construct()
    {
        DbCrud::__construct();
        $this->conn = $this->getConnection();
        return;
    }

    public function insertUser($data)
    {
        try {

            $stmt = $this->conn->prepare('INSERT INTO  tbl_users( firstName, lastName, username, email, password, IDNumber, status, userGroup) 
                                                          VALUES(:firstName,:lastName,:username,:email,:password,:IDNumber,:status,:userGroup)');
            $stmt->execute(array(
                ':firstName' => $data['firstName'],
                ':lastName' => $data['lastName'],
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':IDNumber' => $data['ID_number'],
                ':status' => $data['Status'],
                ':userGroup' => $data['userGroup']
            ));

            $last_id = $this->conn->lastInsertId();

            $return = [
                'status'=>true,
                'ID'=> $last_id
            ];

            return $return;


        } catch (PDOException $e) 
        {
            $msg =  $e->getMessage();

            $return = [
                'status'=>false,
                'Error'=> $msg
            ];
            return $return;
            
        }
    }

    public function updateUser($data)
    {
        try{
            $stmt = $this->conn->prepare("UPDATE tbl_users SET firstName=:firstName, lastName=:lastName, username=:username, email=:email, password=:password, IDNumber=:IDNumber, status=:status, userGroup=:userGroup WHERE userID=:userID;");

            $stmt->execute(
                array(
                    ':userID' => $data['userID'],
                    ':firstName' => $data['firstName'],
                    ':lastName' => $data['lastName'],
                    ':username' => $data['username'],
                    ':email' => $data['email'],
                    ':password' => $data['password'],
                    ':IDNumber' => $data['ID_number'],
                    ':status' => $data['Status'],
                    ':userGroup' => $data['userGroup']
                )                    
            );
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    public function deleteUser($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_users WHERE userID = :id");
            $stmt->execute(array(
                ':id'=>$id
            ));
            return true;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }
    
}