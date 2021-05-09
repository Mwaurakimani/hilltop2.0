<?php
require_once ('../../../App/init.php');
use Lyricorn\Operations\catalogue\product;
use Lyricorn\Operations\stockControl\subStockControl;
use Lyricorn\Operations\stockControl\stockControl;
use Lyricorn\Operations\Sale\Sale;
use Lyricorn\Operations\Sale\subSale;
use Lyricorn\Operations\Transaction\Transaction;



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['TOKEN'] = false;
$test_mode = false;


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
    $data = $prop;
    // var_dump($data);


    switch($action){
        case "create":
            switch($intent){
                case "Add":
                case "Return":
                    //enter entry
                    $controller = new stockControl();
                    $sub_controller = new subStockControl();

                    $entry = $data['entry'];

                    $sql = 'SELECT * FROM tbl_users WHERE username = :username';
                    $user_return = $admin->runQuery($sql);
                    $user_return->execute(array(
                        ':username'=>$_SESSION['USER']
                    ));
                    $user = $user_return->fetchAll();
                    $user = $user[0]['userID'];

                    $entry_data = array(
                        ":fk_entryRep"=>$user,
                        ":entryType"=>$entry['type'],
                        ":Summary"=>$entry['summary'],
                        ":createdBy"=>$user,
                        ":ModifiedBy"=>$user,
                        ":resolved"=>$entry['resolve'],
                    );

                    $return = $controller->insertEntry($entry_data);

                    $id = $return['ID'];

                    //enter sub entries

                    $sub_entries = $data['sub_entry'];

                    foreach ($sub_entries as $value) {
    
                        $entry_data = array(
                            ":fk_stockEntryID"=>$id,
                            ":fk_product"=>$value['prod_id'],
                            ":units"=>$value['prod_unit'],
                            ":price"=>$value['prod_price'],
                        );
    
                        $return = $sub_controller->insertSubEntry($entry_data);

                        //update catalogue
                        $product = new product();

                        $val = array(
                            ":fk_stockEntryID"=>$id,
                            ":fk_product"=>$value['prod_id'],
                            ":units"=>$value['prod_unit'],
                            ":price"=>$value['prod_price'],
                        );

                        $return = $product->stockUpdate($val,"Add");   
                    }

                    $response = array(
                        "status"=>True,
                        "response_code"=>1,
                        "response"=>"Added Successfully!"
                    );
                
                    echo json_encode($response);

                    break;
                case "Remove":
                case "Transfer":
                    //enter entry
                    $controller = new stockControl();
                    $sub_controller = new subStockControl();

                    $entry = $data['entry'];

                    $sql = 'SELECT * FROM tbl_users WHERE username = :username';
                    $user_return = $admin->runQuery($sql);
                    $user_return->execute(array(
                        ':username'=>$_SESSION['USER']
                    ));
                    $user = $user_return->fetchAll();
                    $user = $user[0]['userID'];

                    $entry_data = array(
                        ":fk_entryRep"=>$user,
                        ":entryType"=>$entry['type'],
                        ":Summary"=>$entry['summary'],
                        ":createdBy"=>$user,
                        ":ModifiedBy"=>$user,
                        ":resolved"=>$entry['resolve'],
                    );

                    $return = $controller->insertEntry($entry_data);

                    $id = $return['ID'];

                    //enter sub entries

                    $sub_entries = $data['sub_entry'];

                    foreach ($sub_entries as $value) {
    
                        $entry_data = array(
                            ":fk_stockEntryID"=>$id,
                            ":fk_product"=>$value['prod_id'],
                            ":units"=>$value['prod_unit'],
                            ":price"=>$value['prod_price'],
                        );
    
                        $return = $sub_controller->insertSubEntry($entry_data);

                        //update catalogue
                        $product = new product();

                        $val = array(
                            ":fk_stockEntryID"=>$id,
                            ":fk_product"=>$value['prod_id'],
                            ":units"=>$value['prod_unit'],
                            ":price"=>$value['prod_price'],
                        );

                        $return = $product->stockUpdate($val,"Sub");   
                    }

                    $response = array(
                        "status"=>True,
                        "response_code"=>1,
                        "response"=>"Added Successfully!"
                    );
                
                    echo json_encode($response);

                    break;
                default:
                    exit();
                    break;
            }
            break;
        case "update":
            switch($intent){
                case "Transfer":
                    $sub_entries = $data['sub_entry'];
                    $resolve = $data['entry']['resolve'];

                    $my_stockControl = new stockControl();
                    $data = array(
                        ":Entry_ID" => (int)$prop['id'],
                        ":resolved" => $resolve
                    );
                    
                    $response = $my_stockControl->resolve_transaction($data);


                    $user_id = $admin->get_user_id($_SESSION['USER']);

                    $sale_data = array(
                        ":fk_saleRep" => $user_id,
                        ":saleType"=>"Vehicle",
                        ":sale_amount" => 0
                    );
                    $sale_amount = 0;

                    foreach ($sub_entries as $value) {

                        //update catalogue
                        $product = new product();

                        $val = array(
                            ":fk_product"=>$value['prod_id'],
                            ":units_taken"=>$value['units_taken'],
                            ":units"=>$value['units_returned'],
                            ":amount"=>$value['amount']
                        );

                        // $return = $product->stockUpdate($val,"Add");   

                        var_dump($val);

                        $units_sold = (double) $val[':units_taken'] - (double) $val[':units'];

                        $selling_price = (double) $val[':amount'] / (double) $val[':units_taken'];

                        $amount = $units_sold * $selling_price;

                        $sub_amount = $amount;

                        //collect data
                        $stk_returned = $val[':units'];
                        $sale_price = $selling_price;
                        $fk_stockEntryID =  (int)$prop['id'];
                        $fk_product = $value['prod_id'];
                        $sub_controller = new subStockControl();

                        
                        //update tbl_subStock..... where fk_stockentry = (int)$prop['id'] and fk_product = fk_product

                        $sql = 'UPDATE tbl_SubStockEntry SET stk_returned=:stk_returned,sale_price=:sale_price WHERE fk_stockEntryID=:fk_stockEntryID AND fk_product=:fk_product';
                        $stmt = $sub_controller->runQuery($sql);
                        $stmt->execute(array(
                            ":stk_returned"=>$stk_returned,
                            ":sale_price"=>$sub_amount,
                            ":fk_stockEntryID"=>$fk_stockEntryID,
                            ":fk_product"=>$fk_product
                        ));

                        $sale_amount = $sale_amount + $amount;
                    }

                    $sale_data[':sale_amount'] = $sale_amount;


                    $sale = new Sale();
                    $response = $sale->insertSale($sale_data);
                    $sale_entry_id = (int) $response;

                    if(is_int($sale_entry_id)){
                        $subSaleControl = new subSale();
                        $sale_id = $sale_entry_id;
        
                        foreach ($sub_entries as $value) {
                            $value[":fk_saleID"] = $sale_id;

                            
                            $sold = (double) $value['units_taken'] - (double) $value['units_returned'];
                            $selling_price = (double) $value['amount'] / (double) $value['units_taken'];
                            $sub_total = $sold * $selling_price;
                            
                            $value = array(
                                ":fk_saleID"=>$sale_id,
                                ":fk_product"=>$value['prod_id'],
                                ":quantity"=>$sold,
                                ":price"=>$selling_price,
                                ":sub_total"=>$sub_total,
                                ":created_by"=>$user_id
                            );
                            
                            $sub_sale_entry_ID = $subSaleControl->insertSubSale($value);
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


                    $response = array(
                        "status"=>True,
                        "response_code"=>1,
                        "response"=>"Added Successfully!"
                    );
                
                    echo json_encode($response);

                    break;
                default:
                    exit();
                    break;
            }
            break;
        default:
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