<?php
    require_once ('../../../App/init.php');



    if(empty($catalogue)){
        $data_found = false;
    }else{
        $data_found = true;
    }
?>
<div class="content_body_title">
    <h4>Notifications</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Notifications</li>
        </ol>
    </nav>
</div>

<div class="catalog_list"  id="notification_panel">
    <section>
        <div class="notification_heading">
            <h3>Unresolved Transfers</h3>
        </div>
        <div class="notification_body">
            <?php
                $sql = 'SELECT * FROM tbl_stockControl WHERE entryType=:entryType AND resolved=:resolved ORDER BY dateCreated ASC';
                $stockControl = $admin->runQuery($sql);
                $stockControl->execute(
                    array(
                        ":entryType"=>'Transfer',
                        ":resolved"=>'Unresolved'
                    )
                );

                $stockControl = $stockControl->fetchAll();

                // var_dump($stockControl);
                

                if(empty($stockControl)){
                ?>
                <p>No Unresolved transfers</p>
                <?php
                }else{
                ?>
                   <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Entry ID</th>
                                <th scope="col">Entry Representative</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">summary</th>
                                <th scope="col">Resolve</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($stockControl as $key => $value) {
                            ?>
                                <tr>
                                    <td scope="row">
                                        <p><?php echo ($i) ?></p>
                                    </td>
                                    <td style="overflow: auto;" class="id_holder">
                                        <p><?php
                                                echo $value['Entry_ID'];
                                        ?></p>
                                    </td>
                                    <td class="name">
                                        <p><?php
                                                    if(!is_null($value['fk_entryRep'])){
                                                        $sql = 'SELECT * FROM tbl_users WHERE userID = :userID';
                                                        $val1 = $admin->runQuery($sql);
                                                        $val1->execute(array(
                                                            ":userID"=>$value['fk_entryRep']
                                                        ));
                                                        $user = $val1->fetchAll();

                                                        echo $user[0]['username'];
                                                    };
                                            ?></p>
                                    </td>
                                    <td>
                                        <p><?php
                                                    echo $value['dateCreated'];
                                            ?></p>
                                    </td>
                                    <td>
                                        <p><?php
                                                    echo $value['Summary'];
                                                    ?></p>
                                            </td>
                                    <td onclick="stockHandler.render_update(<?php echo $value['Entry_ID'] ?>)" style="width: 5%;">
                                        <img src="<?php echo ICON_PATH.'edit.png' ?>" alt="">
                                    </td>
                                </tr>
                            <?php   
                                    $i++;
                                }
                            ?>
                        </tbody>
                   </table>
                <?php
                }
            ?>
        </div>
    </section>
    <section>
    <div class="notification_heading">
            <h3>Stock Alerts</h3>
        </div>
        <div class="notification_body">
            <?php
                $sql = 'SELECT * FROM tbl_catalogue WHERE (currentStock - min_limit) < 0 ORDER BY productName ASC';
                $catalogue_return = $admin->runQuery($sql);
                $catalogue_return->execute();
                $catalogue = $catalogue_return->fetchAll();

                // var_dump($catalogue);
                
                
                if(empty($catalogue)){
                    ?>
                    <p>No Low Stocked Products</p>
                    <?php
                    }else{
                    ?>
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Minimum Limit</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($catalogue as $value) {
                            ?>
                                <tr>
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
                                            echo $value['min_limit'];
                                        ?></p>
                                    </td>
                                    <td onclick="stockHandler.render_update(<?php echo $value['productId'] ?>)" style="width: 5%;">
                                        <img src="<?php echo ICON_PATH.'edit.png' ?>" alt="">
                                    </td>
                                </tr>
                            <?php   
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    }
                    ?>
        </div>
    </section>
    <!-- <section>
        <div class="notification_heading">
            <h3>Unresolved Transfers</h3>
        </div>
        <div class="notification_body">

        </div>
    </section> -->
</div>
<div id="dev_error_display">

</div>

<?php
/*
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
                 foreach ($catalogue as $key => $value) {
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
*/

