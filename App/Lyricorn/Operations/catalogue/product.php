<?php
namespace Lyricorn\Operations\catalogue;

use Lyricorn\Operations\catalogue\catalogue;
use PDOException;

class product extends catalogue
{
    function __construct()
    {
        catalogue::__construct();
    }
    public function insertProduct($data)
    {
        try{
            $tracker = $data['allow_stock_tracking'];

            if($tracker == "true"){
                $data['allow_stock_tracking'] = 1;
            }else{
                $data['allow_stock_tracking'] = 0;
            }
    
            $user = $_SESSION['USER'];
    
            $sql = 'SELECT * FROM tbl_users WHERE username = :name';
            $user_return = $this->runQuery($sql);
            $user_return->execute(array(
                ':name'=>$user
            ));
            $users = $user_return->fetchAll();
            $user_id = $users[0]["userID"];
    
            $stmt = $this->conn->prepare('INSERT INTO tbl_catalogue (productName ,  currentStock, units, min_limit, max_limit, sale_price, supply_price , created_by, modified_by, notes, allow_stock_tracking) VALUES (:productName ,  :currentStock, :units, :min_limit, :max_limit, :sale_price, :supply_price, :created_by, :modified_by, :notes, :allow_stock_tracking)');

    
            $data = array(
                ':productName'=> $data['productName'],
                ':currentStock'=> $data['currentStock'],
                ':units'=> $data['units'],
                ':min_limit'=> $data['min_limit'],
                ':max_limit'=> $data['max_limit'],
                ':sale_price'=> $data['sale_price'],
                ':supply_price'=> $data['supply_price'],
                ':created_by' => $user_id,
                ':modified_by' => $user_id,
                ':notes'=> $data['notes'],
                ':allow_stock_tracking'=> $data['allow_stock_tracking'],
            );

            $stmt->execute(
                $data                 
            );
    
            return true;
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

    public function stockUpdate($data,$opt){
        $id = $data[':fk_product'];
        $units = $data[':units'];

        $sql = 'SELECT * FROM tbl_catalogue WHERE productId = :productId';
        $prod = $this->runQuery($sql);
        $prod->execute(array(
            ':productId'=>$id
        ));
        $prod = $prod->fetchAll();
        $current = $prod[0]['currentStock'];
        $stock = 0;

        if($opt == "Add"){
            $stock = (double) $current + (double) $units;
        }elseif($opt == "Sub"){
            $stock = (double) $current - (double) $units;
        }else{
            exit();
        }


        try{
            $stmt = $this->conn->prepare("UPDATE tbl_catalogue SET currentStock=:currentStock WHERE productId=:productId;");

            
            $stmt->execute(
                array(
                    ':productId'=>$id,
                    ':currentStock'=> $stock
            ));

            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function resolve($data){
        $id = $data[':fk_product'];
        $units = $data[':units_taken'];

        $sql = 'SELECT * FROM tbl_catalogue WHERE productId = :productId';
        $prod = $this->runQuery($sql);
        $prod->execute(array(
            ':productId'=>$id
        ));
        $prod = $prod->fetchAll();
        $current = $prod[0]['currentStock'];
        $stock = 0;
        $stock = (double) $current + (double) $units;

        try{
            $stmt = $this->conn->prepare("UPDATE tbl_catalogue SET currentStock=:currentStock WHERE productId=:productId;");

            
            $stmt->execute(
                array(
                    ':productId'=>$id,
                    ':currentStock'=> $stock
            ));

            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}