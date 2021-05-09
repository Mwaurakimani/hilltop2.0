<?php

use Lyricorn\Operations\Sale\Sale;
use Lyricorn\Operations\Sale\subSale;
use Lyricorn\Operations\Transaction\Transaction;

require_once ('../../../App/init.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['TOKEN'] = false;
$test_mode = false;
$catalogue = null;

if (isset($_SESSION['TOKEN'])) {
    $response = array(
        "status"=>false,
        "response_code"=>1,
        "response"=>"Premature Termination"
    );

    $params = array();

    $post = null;
    $action = null;
    $intent = null;
    $prop = null;

    if($test_mode){
        array_push($params,extract_data());
        $post = $params[0];

        $action = $post['action'];
        $intent = $post['intent'];
        $user = $post['data']['user'];
    }else{
        $post = $_REQUEST;
        $action = $post['action'];
        $intent = $post['intent'];
        $prop = $post['data']['prop'];
    }

    switch($action){
        case "create":
            //add sale
            $total_amount = 0; 
            $sales = $prop['sales'];
            $transactions = $prop['transaction'];
            $sale = new Sale();
            $subSale = [];

            $user = $_SESSION['USER'];
    
            $sql = 'SELECT * FROM tbl_users WHERE username = :name';
            $user_return = $sale->runQuery($sql);
            $user_return->execute(array(
                ':name'=>$user
            ));
            $users = $user_return->fetchAll();
            $user_id = $users[0]["userID"];

            
            foreach ($sales as $value) {
                $product_id = $value[0];
                $quantity = $value[1];
                
                $product = null;

                $sql = "SELECT * FROM tbl_catalogue WHERE productId = :id";
                $catalogue_return = $admin->runQuery($sql);
                $catalogue_return->execute(array(
                    ":id"=>$product_id
                ));
                $catalogue = $catalogue_return->fetchAll();

                $price = $catalogue[0]['sale_price'];
                $product = $catalogue[0];

                $sub_total = (double) $price * (double) $quantity;

                $total_amount = $total_amount + $sub_total;
                $sub_sale_elem = array(
                    ":fk_product" => (int)$product_id,
                    ":quantity" => $quantity,
                    ":price" => $price,
                    ":sub_total" => $sub_total,
                    ":created_by" =>$user_id
                );

                array_push($subSale,$sub_sale_elem);
            }
            
            $pass_data = array(
                ":fk_saleRep"=>$user_id,
                ":saleType"=>"Retail",
                ":sale_amount"=>$total_amount
            );

            $response = $sale->insertSale($pass_data);
            $sale_entry_id = (int) $response;

            if(is_int($sale_entry_id)){
                $subSaleControl = new subSale();
                $sale_id = $sale_entry_id;

                foreach ($subSale as $value) {
                    $value[":fk_saleID"] = $sale_id;

                    $sub_sale_entry_ID = $subSaleControl->insertSubSale($value);


                    // var_dump($sub_sale_entry_ID);
                    // exit();

                    if(is_int((int) ($sub_sale_entry_ID))){
                        $transaction = new Transaction();
        
                        foreach ($transactions as $value1) {
                            $val[":fk_saleRef"] = $sale_id;
                            $val[":Amount"] = $value1['amount'];
                            $val[":Method"] = $value1['method'];
                            $val[":created_by"] = $user_id;
        
                            $var = $transaction->insertTransaction($val);
                        }
                    }else{
                        $response = array(
                            "status"=>false,
                            "response_code"=>1,
                            "response"=>"Error adding Sale"
                        );
                    
                        echo json_encode($response);
                    }
                }

                $response = array(
                    "status"=>true,
                    "response_code"=>1,
                    "response"=>"Sale Added"
                );
            
                echo json_encode($response);
            }else{
                $response = array(
                    "status"=>false,
                    "response_code"=>1,
                    "response"=>"Error adding Sale"
                );
            
                echo json_encode($response);
            }
            break;
        default:
            echo "processing...";
        break;
    }

}else{
    $response = array(
        "status"=>false,
        "response_code"=>1,
        "response"=>"Token was not Passed"
    );

    echo json_encode($response);
}
?>


