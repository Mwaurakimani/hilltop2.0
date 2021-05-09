<?php
namespace Lyricorn\Operations\Transaction;

use Lyricorn\User\User;
use PDOException;

class Transaction extends User
{
    function __construct()
    {
        User::__construct();
    }
    public function insertTransaction($data)
    {
        try{
            $stmt = $this->conn->prepare('INSERT INTO tbl_transactions (fk_saleRef,Amount,Method,created_by) VALUES (:fk_saleRef,:Amount,:Method,:created_by)');

            $stmt->execute(
                $data                 
            );

            $id = $this->conn->lastInsertId();
            return $id;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function updateProduct($data)
    {
        try{

            $tracker = $data['allow_stock_tracking'];

            if($tracker == "true"){
                $data['allow_stock_tracking'] = 1;
            }else{
                $data['allow_stock_tracking'] = 0;
            }

            $stmt = $this->conn->prepare("UPDATE tbl_catalogue SET productName=:productName, currentStock=:currentStock, units=:units, min_limit=:min_limit, max_limit=:max_limit, sale_price=:sale_price, notes=:notes,allow_stock_tracking=:allow_stock_tracking,supply_price=:supply_price WHERE productId=:productId;");

            
            $stmt->execute(
                array(
                    ':productId'=>$data['productId'],
                    ':productName'=> $data['productName'],
                    ':currentStock'=> $data['currentStock'],
                    ':units'=> $data['units'],
                    ':min_limit'=> $data['min_limit'],
                    ':max_limit'=> $data['max_limit'],
                    ':sale_price'=> $data['sale_price'],
                    ':notes'=> $data['notes'],
                    ':allow_stock_tracking'=> $data['allow_stock_tracking'],
                    ':supply_price'=> $data['supply_price']
                )                    
            );

            
            
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    public function deleteProduct($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_catalogue WHERE productId = :id");
            $stmt->execute(array(
                ':id'=>$id
            ));
            return true;
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }
}