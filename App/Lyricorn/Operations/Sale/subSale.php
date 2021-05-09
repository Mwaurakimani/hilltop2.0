<?php
namespace Lyricorn\Operations\Sale;

use PDOException;

class subSale extends Sale
{
    function __construct()
    {
        Sale::__construct();
    }
    public function insertSubSale($data)
    {
        try{
            $stmt = $this->conn->prepare('INSERT INTO tbl_subSale (fk_saleID,fk_product,quantity,price,sub_total,created_by) VALUES (:fk_saleID,:fk_product,:quantity,:price,:sub_total,:created_by)');
            $stmt->execute(
                $data                 
            );
            $id = $this->conn->lastInsertId();

            echo $id;
            return $id;
            // $this->updateStock($data);

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function updateStock($data){
        $product_id = $data[':fk_product'];
        $quantity = $data[':quantity'];

        $sql = 'SELECT * FROM tbl_catalogue WHERE productId = :productId';
        $catalogue_return = $this->runQuery($sql);
        $catalogue_return->execute(array(
            ':productId'=>$product_id
        ));
        

        $product = $catalogue_return->fetchAll();

        if(empty($product)){
            exit();
        }else{
            $product = $product[0];
            $db_quantity = $product['currentStock'];
            $new_quantity = $db_quantity - $quantity;

            $sql = "UPDATE tbl_catalogue SET currentStock=:currentStock WHERE productId = :productId";
            $stmt = $this->runQuery($sql);
            $stmt->execute(array(
                ':currentStock'=>$new_quantity,
                ':productId'=>$product_id
            ));
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