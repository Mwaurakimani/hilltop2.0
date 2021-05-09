<?php
    require_once ('../../../App/init.php');

    $params = (array) json_decode(file_get_contents('php://input'), TRUE);
    $items2 = null;
    $data_found = null;
    $data_found2 = null;

    if(count($params) >= 1){
        $sql = 'SELECT * FROM tbl_stockControl WHERE Entry_ID = :Entry_ID';
        $val1 = $admin->runQuery($sql);
        $val1->execute(array(
            ":Entry_ID"=>$params[0]
        ));
        $items = $val1->fetchAll();
    
        if(empty($items)){
            $data_found = false;
        }else{
            $data_found = true;
            $item = $items[0];
    
            $sql = 'SELECT * FROM tbl_SubStockEntry WHERE fk_stockEntryID = :fk_stockEntryID';
            $val1 = $admin->runQuery($sql);
            $val1->execute(array(
                ":fk_stockEntryID"=>$params[0]
            ));
    
            $items2 = $val1->fetchAll();
    
            if(empty($items2)){
                $data_found2 = false;
            }else{
                $data_found2 = true;
            }
        }
    }else{
        $data_found1 = false;
        $data_found2 = null;
    }

    // var_dump($items2);
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
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                New Entry
            </button>
            <?php
                if($data_found){
            ?>
            
            <?php
                    if(($item['entryType'] == 'Transfer') && ($item['resolved'] == "Unresolved")){
                        ?>
                        <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="stockHandler.resolve_transfer()">
                            Resolve
                        </button>
                        <?php
                    }else{
                        ?>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                            Update Entry
                        </button> -->
                        <?php
                    }
                }else{
            ?>
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="stockHandler.create_stockAction()">
                Add Entry
            </button>
            <?php
                }
            ?>
        </div>
        <!-- <div class="search_field">
            <input type="search" placeholder="Search for Item">
        </div>
        <div class="export_group">
            <button type="button" class="btn btn-success" data-toggle="button" aria-pressed="false" autocomplete="off">
                Quotation
            </button>
        </div> -->
        <div class="parent_data_sort">
            <div class="input_select_item">
                <select name="action" id="" onchange="stockHandler.changeAction()" <?php
                                if($data_found){
                                    echo "disabled";
                                }else{
                                    echo"";
                                }
                    ?>>
                    

                    <?php 
                            if(!$data_found){
                                ?>
                                <option value="Add" selected="selected">Add</option>
                                <option value="Remove" >Remove</option>
                                <option value="Transfer" >Transfer</option>
                                <option value="Return" >Return</option>
                                <?php
                            }else{
                                $keys = ['Add','Remove','Transfer','Return'];
                                $selected = $item['entryType'];

                                foreach ($keys as $value) {
                                    if($value == $selected){
                                    ?>
                                        <option value="<?php echo $value ?>" selected="selected" ><?php echo $value ?></option>
                                    <?php
                                    }else{
                                    ?>
                                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php
                                    }}
                            }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="context_bar">

    </div>
</div>
<div class="catalog_list"  id="catalog_panel_1">
    <div class="stockControl_view">
        <div class="product_search" id="select_product">
            <div class="input_elem" >
                <input type="text" onkeyup="stockHandler.get_products()" onblur="stockHandler.hide_selector(id)" onfocus="stockHandler.show_selector(id)">
            </div>
            <div class="item_display">
            </div>
        </div>
        <div class="body_holder">
            <?php
                if(isset($item['entryType']) && ($item['entryType'] == "Transfer")){
            ?>
             <table class="table table-striped table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            <input type="checkbox" class="check_all" name="check_all" onchange="catalogue_table.toggle_all_check()">
                        </th>
                        <th scope="col">Product ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Units Transferred</th>
                        <th scope="col">Units Returned</th>
                        <th scope="col">Price</th>
                        <!-- <th scope="col">Delete</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($data_found2){

                            foreach ($items2 as $sub_entry) {
                    ?>
                        <tr class="selected">
                            <th scope="col">
                                <input type="checkbox" class="check_all">
                            </th>
                            <td style="overflow: auto;" class="id_holder">
                                <p><?php echo $sub_entry['fk_product'] ?></p>
                            </td>
                            <td class="name">
                                <p>
                                <?php
                                    $sql = 'SELECT * FROM tbl_catalogue WHERE productId = :productId';
                                    $val1 = $admin->runQuery($sql);
                                    $val1->execute(array(
                                        ":productId"=>$sub_entry['fk_product']
                                    ));

                                    $val = $val1->fetchAll();

                                    echo $val[0]['productName'];
                                ?></p>
                            </td>
                            <td>
                                <div class="input" style="width: 20%;">
                                    <p><?php echo $sub_entry['units'] ?></p>
                                </div>
                            </td>
                            <td>
                                <div class="input">
                                    <?php
                                        if($data_found && ($item['entryType'] == 'Transfer') && ($item['resolved'] == "Resolved")){
                                            echo $sub_entry['stk_returned'];
                                        }else{
                                            ?>
                                            <input type="number" max="<?php echo $sub_entry['units'] ?>" value="0">
                                            <?php
                                        }
                                    ?>
                                    
                                </div>
                            </td>
                            <td style="width:20%">
                                <div class="input">
                                <?php
                                        if($data_found && ($item['entryType'] == 'Transfer') && ($item['resolved'] == "Resolved")){
                                            echo $sub_entry['sale_price'];
                                        }else{
                                            ?>
                                            <p><?php echo $sub_entry['price'] ?></p>
                                            <?php
                                        }
                                    ?>
                                    
                                </div>
                            </td>
                            <!-- <td onclick="stockHandler.remover_item()">
                                <img src="http://hilltop2.local/res/images/icons/trash.png" alt="">
                            </td> -->
                        </tr>
                    <?php
                           }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                }else{
            ?>
            <table class="table table-striped table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            <input type="checkbox" class="check_all" name="check_all" onchange="catalogue_table.toggle_all_check()">
                        </th>
                        <th scope="col">Product ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Units</th>
                        <th scope="col">Price</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($data_found2){

                            foreach ($items2 as $sub_entry) {
                    ?>
                        <tr class="selected">
                            <th scope="col">
                                <input type="checkbox" class="check_all">
                            </th>
                            <td style="overflow: auto;" class="id_holder">
                                <p><?php echo $sub_entry['EntryID'] ?></p>
                            </td>
                            <td class="name">
                                <p>
                                <?php
                                    $sql = 'SELECT * FROM tbl_catalogue WHERE productId = :productId';
                                    $val1 = $admin->runQuery($sql);
                                    $val1->execute(array(
                                        ":productId"=>$sub_entry['fk_product']
                                    ));

                                    $val = $val1->fetchAll();

                                    echo $val[0]['productName'];
                                ?></p>
                            </td>
                            <td>
                                <div class="input">
                                    <input type="number" min="1" value="<?php echo $sub_entry['units'] ?>">
                                </div>
                            </td>
                            <td>
                                <div class="input">
                                    <input type="number" min="1" value="<?php echo $sub_entry['price'] ?>">
                                </div>
                            </td>
                            <td onclick="stockHandler.remover_item()">
                                <img src= "<?php echo APP_http_ROUT; ?>/res/images/icons/trash.png" alt="">
                            </td>
                        </tr>
                    <?php
                           }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                }
            ?>
            <div class="stockControl_details">
                <h3>Entry Details</h3>
                <?php
                    if($data_found){
                ?>
                <div class="input_elem" >
                    <label for="">Entry ID</label>
                    <input disabled type="text" value="<?php echo $item['Entry_ID'] ?>" name="stockControl_ID">
                </div>
                <div class="input_elem" >
                    <label for="">Date Created</label>
                    <input disabled type="text" value="<?php echo $item['dateCreated'] ?>">
                </div>
                <div class="input_elem" >
                    <label for="">Creator ID</label>
                    <input disabled type="text" value="<?php echo $item['createdBy'] ?>">
                </div>
                <div class="input_elem" >
                    <label for="">Date Modified</label>
                    <input disabled type="text" value="<?php echo $item['dateModified'] ?>">
                </div>
                <div class="input_elem" >
                    <label for="">Modifier ID</label>
                    <input disabled type="text" value="<?php echo $item['modifiedBy'] ?>">
                </div>
                <?php
                    }
                ?>
                <div class="input_elem">
                    <label for="">Summary</label>
                    <textarea name="Summary" id="" cols="30" rows="10"><?php if($data_found){ echo($item['Summary']); } ?></textarea>
                </div>
                <div class="input_elem">
                    <label for="">Status</label>
                    <select name="resolve" id="" <?php
                        if($data_found && ($item['entryType'] == 'Transfer') && ($item['resolved'] == "Resolved")){
                            echo "Disabled";
                        }
                    ?>>
                        

                        <?php 
                            if(!$data_found){
                                ?>
                                <option value="Resolved">Resolved</option>
                                <option value="Unresolved">Unresolved</option>
                                <?php
                            }else{
                                $keys = ['Resolved','Unresolved'];
                                $selected = $item['resolved'];

                                foreach ($keys as $value) {
                                    if($value == $selected){
                                    ?>
                                        <option value="<?php echo $value ?>" selected="selected" ><?php echo $value ?></option>
                                    <?php
                                    }else{
                                    ?>
                                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php
                                    }}
                            }
                        ?>

                        <?php 
                            if($data_found && ($item['entryType'] == 'Transfer')){
                            ?>
                            <script>
                                $("[name='resolve']").val("Resolved");
                            </script>
                            <?php
                            }
                        ?>

                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dev_error_display">

</div>