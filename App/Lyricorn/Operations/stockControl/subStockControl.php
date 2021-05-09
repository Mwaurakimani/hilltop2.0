<?php
namespace Lyricorn\Operations\stockControl;

use PDOException;

class subStockControl extends StockControl
{
    function __construct()
    {
       stockControl::__construct();
    }
    function insertSubEntry($data)
    {
        try {

            $stmt = $this->conn->prepare('INSERT INTO  tbl_SubStockEntry (fk_stockEntryID,fk_product,units,price) VALUES(:fk_stockEntryID,:fk_product,:units,:price)');
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

    
}