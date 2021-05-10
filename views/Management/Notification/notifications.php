<?php
    require_once ('../../../App/init.php');

    $sql = 'SELECT * FROM tbl_catalogue ORDER BY productName ASC';
    $catalogue_return = $admin->runQuery($sql);
    $catalogue_return->execute();
    $catalogue = $catalogue_return->fetchAll();

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
                $sql = 'SELECT * FROM tbl_catalogue ORDER BY productName ASC';
                $catalogue_return = $admin->runQuery($sql);
                $catalogue_return->execute();
                $catalogue = $catalogue_return->fetchAll();
            ?>
        </div>
    </section>
    <section>
    <div class="notification_heading">
            <h3>Stock Alerts</h3>
        </div>
        <div class="notification_body">

        </div>
    </section>
    <section>
    <div class="notification_heading">
            <h3>Unresolved Transfers</h3>
        </div>
        <div class="notification_body">

        </div>
    </section>
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