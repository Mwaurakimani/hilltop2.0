<?php
    require_once ('../../../App/init.php');

    $sql = 'SELECT * FROM tbl_stockControl';
    $val1 = $admin->runQuery($sql);
    $val1->execute();
    $items = $val1->fetchAll();


    if(empty($catalogue)){
        $data_found = false;
    }else{
        $data_found = true;
    }

    print_r($items);
    exit();
?>
<div class="content_body_title">
    <h4>Stock Control</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Stock Control</li>
        </ol>
    </nav>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="stockHandler.render_update()">
                New Entry
            </button>
        </div>
        <!-- <div class="search_field">
            <input type="search" placeholder="Search for Item">
        </div>
        <div class="export_group">
            <button type="button" class="btn btn-success" data-toggle="button" aria-pressed="false" autocomplete="off">
                Quotation
            </button>
        </div> -->
    </div>
    <div class="context_bar">

    </div>
</div>
<div class="catalog_list"  id="catalog_panel_1">
    <table class="table table-striped table-bordered table-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">
                    <input type="checkbox" class="check_all" name="check_all" onchange="catalogue_table.toggle_all_check()">
                </th>
                <th scope="col">#</th>
                <th scope="col">Entry ID</th>
                <th scope="col">Entry Representative</th>
                <th scope="col">Type</th>
                <th scope="col">Date Created</th>
                <th scope="col">summary</th>
                <th scope="col" style="width: 10%;">resolve</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                 $i = 1;
                 foreach ($items as $key => $value) {
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
                                    echo $value['entryType'];
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
                    <td onclick="catalogue.delete_product(<?php echo $value['Entry_ID'] ?>)" >
                        <img src="<?php echo ICON_PATH.'trash.png' ?>" alt="">
                    </td>
                </tr>
            <?php   
                    $i++;
                }
            ?>
        </tbody>
    </table>
</div>
<div id="dev_error_display">

</div>
