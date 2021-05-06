<?php
use Lyricorn\Operations\catalogue\product;

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
        case "read":
            $word = $prop;

            if($word == ""){
                ?>
                <div class="no_item">
                    <p>No items found!!!</p>
                </div>
                <?php
                exit();
            }
            $sql = "SELECT * FROM tbl_catalogue WHERE productName LIKE CONCAT('%', :productName, '%') LIMIT  20";
            $catalogue_return = $admin->runQuery($sql);
            $catalogue_return->execute(array(
                ":productName"=>$word
            ));
            $catalogue = $catalogue_return->fetchAll();

            if(empty($catalogue)){
                ?>
                <div class="no_item">
                    <p>No items found!!!</p>
                </div>
                <?php
                exit();
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
?>

<div class="sub_table_view">
    <table>
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
            </tr>
        </thead>
        <tbody>

            <?php
                //here
                foreach($catalogue as $product){
            ?>
            <tr onclick="pos_obj.select_item(<?php echo $product['productId'] ?>)">
                <td><?php echo $product['productName'] ?></td>
                <td><?php echo $product['sale_price'] ?></td>
                <td><?php echo $product['currentStock'] ?></td>
            </tr>
            <?php
                //here
                }
            ?>
        </tbody>
    </table>
</div>



