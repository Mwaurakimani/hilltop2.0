<?php
    require_once ('../../../App/init.php');

    $params = (array) json_decode(file_get_contents('php://input'), TRUE);
    $data_found= null;

    if(isset($params[0])){
        $id = $params[0];

        $sql = 'SELECT * FROM tbl_catalogue WHERE productId = :productId';
        $catalogue_return = $admin->runQuery($sql);
        $catalogue_return->execute(array(
            ':productId'=>$id
        ));
        

        $product = $catalogue_return->fetchAll();

        if(empty($product)){
            $data_found = false;
        }else{
            $data_found = true;
            $product = $product[0];
        }
    }else{
        $data_found = false;
    }

    // var_dump($product);
?>


<div class="content_body_title">
    <h4>Catalogue</h4>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"> <a href="#" onclick=" navigation_panel
                                                                    .pre_def_intent('Catalogue')
                                                                    .render_body_content(path.Operations.catalogue + 'list.php', catalogue_init);
                                                                                ;return false" >Catalogue</a></li>
            <?php
                if($data_found){
                    ?>
                    <li class="breadcrumb-item active"> <?php echo $product['productName']; ?></li>
                    <?php
                }else{
                    ?>
                    
                    <li class="breadcrumb-item active"> 
                    <?php
                        if($data_found){
                            echo 'new-product';
                        } 
                     ?></li>
                    <?php
                }
            ?>
            

        </ol>
    </nav>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <?php
                if($data_found != true){
                    ?>
                    <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="catalogue.create_product()">
                        Create
                     </button>
                    <?php
                }
            ?>
            </button>
            <?php
                if($data_found){
                    ?>
                    <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="catalogue.update_product()">
                        Update
                    </button>
                    <?php
                }
            ?>
        </div>
        <div class="search_field">
            <!-- <input type="search" placeholder="Search for Item"> -->
        </div>
        <div class="export_group">
        </div>
        <div class="parent_data_sort">
        </div>
    </div>
    <div class="context_bar">

    </div>
</div>
<div id="catalog_panel_1">
    <div id="catalog_form">
        <div class="item_name">
            <p>Name:</p>
            <input type="text" name="productName" value='<?php if($data_found){ echo $product["productName"]; }else{ echo "";}?>'>
        </div>
        <div class="product_details">
            <div class="store_details">
                <div class="entry_card">
                    <div class="input_group_1">
                        <label for="">Product ID:</label>
                        <input disabled type="text" name="productId" value='<?php if($data_found){ echo $product["productId"]; }else{ echo "";}?>'>
                    </div>
                </div>
                <div class="entry_card">
                    <h3>Stock</h3>
                    <div class="input_group_1">
                        <label for="">Current Stock:</label>
                        <input type="text" name="currentStock" value='<?php if($data_found){ echo $product["currentStock"]; }else{ echo "";}?>'>
                        <input id="allow_track" type="checkbox" name="allow_stock_tracking" onchange='toggle_check_box( $(document.getElementById("allow_track")))'>
                        <?php
                            if($data_found){
                                if($product['allow_stock_tracking']){
                                    ?>
                                    <script>
                                        $('[name="allow_stock_tracking"]').prop('checked',true);
                                        $('[name="allow_stock_tracking"]').prop('value',true);
                                        
                                    </script>
                                    <?php
                                }else{
                                    ?>
                                    <script>
                                        $('[name="allow_stock_tracking"]').prop('checked',false);
                                        $('[name="allow_stock_tracking"]').prop('value',false);
                                        
                                    </script>
                                    <?php
                                }
                            }else{
                                ?>
                                    <script>
                                        $('[name="allow_stock_tracking"]').prop('checked',false);
                                        $('[name="allow_stock_tracking"]').prop('value',false);
                                        
                                    </script>
                                <?php
                            }
                        ?>
                        <span>Allow stock tracking? </span>
                        
                    </div>
                    <div class="input_group_1">
                        <label for="">Units:</label>

                        <select name="units" id="">
                            <?php 
                                if(!$data_found){
                                    ?>
                                    <option value="Bottle" selected="selected">Bottle</option>
                                    <option value="Box">Box</option>
                                    <?php
                                }else{
                                    $keys = ['Box','Bottle'];
                                    $selected = $product['units'];

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
                                }?>
                                
                        </select>
                        
                    </div>
                    <div class="input_group_1">
                        <label for="">Stock Limits:</label>
                        <div class="min_max">
                            <div class="min_stock">
                                <label for="">Min</label>
                                <input type="text" name="min_limit" value='<?php if($data_found){ echo $product["min_limit"]; }else{ echo 0;}?>'>
                            </div>
                            <div class="img">

                            </div>
                            <div class="max_stock">
                                <label for="">Max</label>
                                <input type="text" name="max_limit" value='<?php if($data_found){ echo $product["max_limit"]; }else{ echo 0;}?>'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="entry_card">
                    <h3>Price</h3>
                    <div class="input_group_1">
                        <label for="">Sale Price:</label>
                        <input type="text" name="sale_price" value='<?php if($data_found){ echo $product["sale_price"]; }else{ echo 0;}?>'>
                        <!-- <input type="checkbox" name="vehicle1" value="Bike"> <span>Lock price? </span> -->
                    </div>
                    <div class="input_group_1">
                        <label for="">Supply Price:</label>
                        <input type="text" name="supply_price" value='<?php if($data_found){ echo $product["supply_price"]; }else{ echo 0;}?>'>
                        <!-- <input type="checkbox" name="vehicle1" value="Bike"> <span>Lock price? </span> -->
                    </div>
                </div>
            </div>
            <div class="management_details">
                <div class="image_entry">

                </div>
                <div class="input_comment">
                    <div class="entry_card">
                        <h3>Notes</h3>
                        <div class="input_group_1">
                            <label for="">Notes :</label>
                            <textarea name="notes" id="" cols="30" rows="10"><?php if($data_found){ echo $product["notes"]; }else{ echo "";}?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dev_error_display">

</div>