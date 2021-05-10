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


    $prop = $_REQUEST['text'];

    // var_dump($prop);

    if(!empty($prop)){
        $sql = "SELECT * FROM tbl_catalogue WHERE productName LIKE CONCAT('%', :productName, '%') ORDER BY productName ASC ";
        $catalogue_return = $admin->runQuery($sql);
        $catalogue_return->execute(array(
            ":productName"=>$prop
        ));
        $catalogue = $catalogue_return->fetchAll();
    
        if(empty($catalogue)){
            $data_found = false;
            ?>
            <div class="no_product_found">
                <p>No Products Found!</p>
            </div>
            <?php
            exit();
        }else{
            $data_found = true;
        }
    }else{
        $sql = 'SELECT * FROM tbl_catalogue';
        $catalogue_return = $admin->runQuery($sql);
        $catalogue_return->execute();
        $catalogue = $catalogue_return->fetchAll();
    
        if(empty($catalogue)){
            $data_found = false;
            exit();
        }else{
            $data_found = true;
        }
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

<table class="table table-striped table-bordered table-sm">
    <thead class="thead-dark">
        <tr>
            <th scope="col">
                <input type="checkbox" class="check_all" name="check_all" onchange="catalogue_table.toggle_all_check()">
            </th>
            <th scope="col">#</th>
            <th scope="col">Product ID</th>
            <th scope="col">Name</th>
            <th scope="col">Qty</th>
            <th scope="col">date modified</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
            foreach ($catalogue as $value) {
        ?>
            <tr class="selected">
                <th scope="col">
                    <input type="checkbox" class="check_all">
                </th>
                <td scope="row">
                    <p><?php echo ($i) ?></p>
                </td>
                <td style="overflow: auto;" class="id_holder">
                    <p><?php
                            echo $value['productId'];
                    ?></p>
                </td>
                <td class="name">
                    <p><?php
                                echo $value['productName'];
                        ?></p>
                </td>
                <td>
                    <p><?php
                                echo $value['currentStock'];
                        ?></p>
                </td>
                <td>
                    <p><?php
                                echo $value['date_modified'];
                        ?></p>
                </td>
                <td onclick="catalogue.render_update()">
                    <img src="<?php echo ICON_PATH.'edit.png' ?>" alt="">
                </td>
                <td onclick="catalogue.delete_product(<?php echo $value['productId'] ?>)" >
                    <img src="<?php echo ICON_PATH.'trash.png' ?>" alt="">
                </td>
            </tr>
            <?php   
                    $i++;
                }
            ?>
    </tbody>
</table>