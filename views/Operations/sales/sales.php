<?php
    require_once ('../../../App/init.php');

    $sql = 'SELECT * FROM tbl_sales';
    $val1 = $admin->runQuery($sql);
    $val1->execute();
    $items = $val1->fetchAll();

    if(empty($catalogue)){
        $data_found = false;
    }else{
        $data_found = true;
    }
?>
<div class="content_body_title">
    <h4>Sales</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Sales</li>
        </ol>
    </nav>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="navigation_panel
                .pre_def_intent('P.O.S')
                .render_body_content(path.Operations.POS + 'POS.php', $('.item_content').init(pos_init));">
                Add
            </button>
        </div>
        <!-- 
            <div class="search_field">
                <input type="search" placeholder="Search for Item">
            </div>
            <div class="export_group">
                <button type="button" class="btn btn-warning" data-toggle="button" aria-pressed="false" autocomplete="off">
                    CSV
                </button>
                <button type="button" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off">
                    PDF
                </button>
            </div>
            <div class="parent_data_sort">
                <div class="input_select_item">
                    <select name="" id="">
                        <option value="">Enable Sort</option>
                        <option value="">Disable Sort</option>
                    </select>
                </div>
                <div class="input_select_item">
                    <select name="" id="">
                        <option value="">Enable Filter</option>
                        <option value="">Disable Filter</option>
                    </select>
                </div>
            </div>
        -->
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
                <th scope="col">Sale ID</th>
                <th scope="col">Sales Representative</th>
                <th scope="col">Amount</th>
                <th scope="col">Date Created</th>
                <th scope="col">View</th>
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
                                echo $value['sale_ID'];
                        ?></p>
                    </td>
                    <td class="name">
                        <p><?php
                                    echo $value['fk_saleRep'];
                            ?></p>
                    </td>
                    <td>
                        <p><?php
                                    echo $value['sale_amount'];
                            ?></p>
                    </td>
                    <td>
                        <p><?php
                                    echo $value['dateCreated'];
                            ?></p>
                    </td>
                    <td onclick="Sale_handler.render_sale()">
                        <img src="<?php echo ICON_PATH.'edit.png' ?>" alt="">
                    </td>
                    <td onclick="catalogue.delete_product(<?php echo $value['sale_ID'] ?>)" >
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
