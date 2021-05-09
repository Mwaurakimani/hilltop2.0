<?php
    require_once ('../../../App/init.php');
    
    $params = (array) json_decode(file_get_contents('php://input'), TRUE);
    $data_found= null;

    if(isset($params[0])){
        $id = $params[0];

        $sql = 'SELECT * FROM tbl_sales WHERE sale_ID = :sale_ID';
        $val1 = $admin->runQuery($sql);
        $val1->execute(array(
            ':sale_ID'=>$id
        ));
        

        $items = $val1->fetchAll();
        $item1 = null;
        $item2 = null;
        $item3 = null;

        if(empty($items)){
            
        }else{
            $data_found = true;
            $item1 = $items[0];

            

            $sql = 'SELECT * FROM tbl_subsale WHERE fk_saleID = :fk_saleID';
            $val2 = $admin->runQuery($sql);
            $val2->execute(array(
                ':fk_saleID'=>$id
            ));

            $items2 = $val2->fetchAll();
            if(empty($items2)){
            }else{
                $data_found = true;
                $item2 = $items2;

                $sql = 'SELECT * FROM tbl_transactions WHERE fk_saleRef = :fk_saleRef';
                $val3 = $admin->runQuery($sql);
                $val3->execute(array(
                    ':fk_saleRef'=>$id
                ));

                $item3 = $val3->fetchAll();

                if(empty($item3)){
                    
                }
            }
        }
        // var_dump($item1);
        // var_dump($item2);
        // var_dump($item3);
    }else{
        $data_found = false;
        echo "no data found";
    }
?>
<div class="content_body_title">
    <h4>Sale</h4>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="navigation_panel
                .pre_def_intent('P.O.S')
                .render_body_content(path.Operations.POS + 'POS.php', $('.item_content').init(pos_init));">
                New Sale
            </button>
        </div>
        <!-- 
            <div class="search_field">
                <input type="search" placeholder="Search for Item">
            </div>
            <div class="export_group">
                <button type="button" class="btn btn-success" data-toggle="button" aria-pressed="false" autocomplete="off">
                    Quotation
                </button>
            </div>
            <div class="parent_data_sort">
                <div class="input_select_item">
                    <select name="" id="">
                        <option value="POS">POS</option>
                        <option value="Management" selected>Management</option>
                    </select>
                </div>
            </div> 
        -->
    </div>
    <div class="context_bar">
        <?php
        if($data_found){
            ?>
            <div class="sale_details">
                <h3>Sales Details</h3>
                <div class="input_group">
                    <p>Sale ID</p>
                    <p><?php echo $item1['sale_ID'];?></p>
                </div>
                <div class="input_group">
                    <p>Sale Representative</p>
                    <p><?php echo $item1['fk_saleRep'];?></p>
                </div>
                <div class="input_group">
                    <p>Sale Type</p>
                    <p><?php echo $item1['saleType'];?></p>
                </div>
                <div class="input_group">
                    <p>Sale Amount</p>
                    <p><?php echo $item1['sale_amount'];?></p>
                </div>
                <div class="input_group">
                    <p>Date Created</p>
                    <p><?php echo $item1['dateCreated'];?></p>
                </div>
            </div>
            <?php
        }
        ?>
        
    </div>
</div>
<div class="sale_detail_elem">
    <div class="table_view">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Sub Total</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($items2 as $value) {
                ?>
                <tr>
                    <th scope="row">#</th>
                    <td class="product-name">
                        <div class="prod_search_elem">
                            <p><?php 
                                $id = $value['fk_product'];
                                $sql = 'SELECT * FROM tbl_catalogue WHERE productId = :productId';
                                $val1 = $admin->runQuery($sql);
                                $val1->execute(array(
                                ':productId'=>$id
                                ));
                                $products = $val1->fetchAll();

                                echo $products[0]['productName'];


                            ?></p>
                        </div>
                    </td>
                    <td class="quantity">
                        <p><?php echo $value['quantity'] ?></p> 
                    </td>
                    <td class="price">
                        <p><?php echo $value['price'] ?></p>
                    </td>
                    <td>
                        <p><?php echo $value['sub_total'] ?></p>
                    </td>
                </tr>
            <?php    
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="sale_action">
        <div class="sale_details">
            <div class="elem_group">
                <p>Amount</p>
                <p id="sale_Amount" ><?php echo "Ksh ".$item1['sale_amount'] ?></p>
            </div>
        </div>
        <div class="sale_action_btn">
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="pos_obj.toggle_transactions()">View Transactions</button>
        </div>
        <div class="transactions">
            <?php
            foreach ($item3 as $value) {
                ?>
                <div class="transaction_elem">
                    <div class="holder">
                        <div class="item_holder">
                            <p>Method:</p>
                            <p><?php echo$value['Method']  ?></p>
                        </div>
                        <div class="item_holder">
                            <p>Amount:</p>
                            <p><?php echo$value['Amount']  ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div id="dev_error_display">

</div>