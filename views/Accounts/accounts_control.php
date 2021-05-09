<?php
require_once ('../../App/init.php');

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
    $user = $prop;


    switch($action){
        case "create":
            $validate_data = validate_user_data($user);
            

            if($validate_data['status']){

                //create the user
                $return = $admin->insertUser($validate_data['user']);

                if($return['status'] == true){
                    $id = $return['ID'];

                    $sql = 'SELECT * FROM tbl_users WHERE userID = :id';
                    $user_return = $admin->runQuery($sql);
                    $user_return->execute(array(
                        ':id'=>$id
                    ));
                    $user = $user_return->fetchAll();

                    if(empty($user)){
                        $response = array(
                            'status'=>false,
                            'response_data'=> $user,
                            'response_stmt'=> "User was NOT Added Successfully!!"
                        );
                        echo json_encode($response);
                    }else{
                        $response = array(
                            'status'=>true,
                            'response_data'=> $user,
                            'response_stmt'=> "User Added Successfully..."
                        );
                        echo json_encode($response);
                    }

                    
                }else{
                    var_dump($return);
                }

            }else{
                $response = array(
                    "status"=>false,
                    "response_code"=>1,
                    "response"=>"Validation Error"
                );
            
                echo json_encode($response);
            }
            break;
        case "update":
            $validate_data = validate_user_data($user);

            if($validate_data['status']){

                //create the user
                $return = $admin->updateUser($validate_data['user']);
                
                $response = array(
                    "status"=>false,
                    "response_code"=>1,
                    "response"=>"Validation Error"
                );

                echo $return;

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
            $validate_data = validate_id($user);

            if($validate_data['status']){

                //delete the user
                $return = $admin->deleteUser($validate_data['id']);

                $return = array(
                    "status" => true,
                    "response_code" => 0,
                    "response" => "User deleted successfully."
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

function validate_user_data($user){
    $val = array(
        "status"=>true,
        "user"=>$user
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