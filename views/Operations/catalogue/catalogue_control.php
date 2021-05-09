<?php

use Lyricorn\Operations\catalogue\product;

require_once ('../../../App/init.php');

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

    $product = $prop;

    switch($action){
        case "create":
            $validate_data = validate_product_data($product);
            

            if($validate_data['status']){

                $obj_product = new product();

                $sql = 'SELECT * FROM tbl_catalogue WHERE productName = :name';
                $prod_return = $obj_product->runQuery($sql);
                $prod_return->execute(array(
                    ':name'=>$validate_data['product']['productName']
                ));
                $prod = $prod_return->fetchAll();

                if(empty($prod)){
                    //create product
                    $return = $obj_product->insertProduct($validate_data['product']);

                    $sql = 'SELECT * FROM tbl_catalogue WHERE productName = :name';
                    $prod_return = $obj_product->runQuery($sql);
                    $prod_return->execute(array(
                        ':name'=>$validate_data['product']['productName']
                    ));
                    $prod = $prod_return->fetchAll();

                    if(empty($prod)){
                        $return = array(
                            "status" => true,
                            "response_code" => 2,
                            "response_stmt" => "Product product was not created!!!"
                        );

                        echo json_encode($return);
                    }else{
                        $return = array(
                            "status" => true,
                            "response_code" => 2,
                            "response_stmt" => "Product created successfully."
                        );

                        echo json_encode($return);
                    }

                    

                }else{
                    $return = array(
                        "status" => true,
                        "response_code" =>2,
                        "response_stmt" => "Product Already Exist."
                    );

                    echo json_encode($return);
                }
                exit();
            }else{
                $response = array(
                    "status"=>false,
                    "response_code"=>"X",
                    "response_stmt"=>"Validation Error"
                );
            
                echo json_encode($response);
            }
            break;
        case "update":
            $validate_data = validate_product_data($product);

            if($validate_data['status']){

                $obj_product = new product();
                //update the user

                $return = $obj_product->updateProduct($validate_data['product']);

                $return = array(
                    "status" => true,
                    "response_code" => 0,
                    "response" => "Product updated successfully."
                );

                echo json_encode($return);
                exit();

            }else{
                $response = array(
                    "status"=>false,
                    "response_code"=>1,
                    "response"=>"Validation Error"
                );
            
                echo json_encode($response);
            }

            break;
        case "delete":
            $validate_data = validate_id($product);

            if($validate_data['status']){

                $obj_product = new product();
                //delete the user

                $return = $obj_product->deleteProduct($validate_data['id']);

                $return = array(
                    "status" => true,
                    "response_code" => 0,
                    "response" => "Product deleted successfully."
                );

                echo json_encode($return);
                exit();

            }else{
                $response = array(
                    "status"=>false,
                    "response_code"=>1,
                    "response"=>"Validation Error"
                );
            }
            break;
        case "get_all_users":
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


function extract_data($data = null){
    $params = (array) json_decode(file_get_contents('php://input'), TRUE);
    return $params;
}

function validate_product_data($product){
    $val = array(
        "status"=>true,
        "product"=>$product
    );
    return $val;
}
function validate_id($id){
    $val = array(
        "status"=>true,
        "id"=>$id
    );
    return $val;
}