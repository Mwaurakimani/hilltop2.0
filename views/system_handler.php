<?php

use Lyricorn\System\Sys_Init;

require_once ('../App/init.php');

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
    $user = null;

    if($test_mode){
        array_push($params,extract_data());
        $post = $params[0];

        $action = $post['data'];
    }else{
        $post = $_REQUEST;
        $action = $post['action'];
    }

    switch($action){
        case "log_out":
            $sys = new Sys_Init();
            $sys->log_out();
            return true;
            break;
        default:
            echo "no handler to initiate";
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