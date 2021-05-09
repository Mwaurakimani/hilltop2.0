<?php
    require_once ('../../../App/init.php');

    $sql = 'SELECT * FROM tbl_catalogue';
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
    <h4>Catalogue</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Catalogue</li>
        </ol>
    </nav>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="catalogue.render_update()">
                Add
            </button>
        </div>
        <div class="search_field">
            <input type="search" placeholder="Search for Item" onkeyup="catalogue.search_product()">
        </div>
        <div class="export_group">
            <button type="button" class="btn btn-warning" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="catalogue.generate_csv_file()">
                CSV
            </button>
        </div>
        <div class="parent_data_sort">
            <div class="input_select_item">
                <select name="" id="">
                    <option value="">Sort A-Z</option>
                    <option value="">Sor tZ-A</option>
                </select>
            </div>
            <!-- <div class="input_select_item">
                <select name="" id="">
                    <option value="">Enable Filter</option>
                    <option value="">Disable Filter</option>
                </select>
            </div> -->
        </div>
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

</div>
<div id="dev_error_display">

</div>
