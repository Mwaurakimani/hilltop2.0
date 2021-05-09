<?php
namespace Lyricorn\Operations\stockControl;

use Lyricorn\User\User;
use PDOException;

class stockControl extends User
{
    function __construct()
    {
        User::__construct();
    }


    function insertEntry($data)
    {
        try {

            $stmt = $this->conn->prepare('INSERT INTO  tbl_stockControl (fk_entryRep,entryType,Summary,resolved,createdBy,ModifiedBy) VALUES(:fk_entryRep,:entryType,:Summary,:resolved,:createdBy,:ModifiedBy)');
            $stmt->execute($data);

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

    function resolve_transaction($data){
        try{
            $stmt = $this->conn->prepare("UPDATE tbl_stockControl SET resolved=:resolved WHERE Entry_ID=:Entry_ID;");
            $stmt->execute($data);

        }catch(PDOException $e){
            $msg =  $e->getMessage();   

            var_dump($msg);
        }
    }
}