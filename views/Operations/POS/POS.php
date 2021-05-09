<?php
    require_once ('../../../App/init.php');
?>
<div class="content_body_title">
    <h4>P.O.S</h4>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="    navigation_panel
        .pre_def_intent('P.O.S')
        .render_body_content(path.Operations.POS + 'pos.php', pos_init);">
                New Sale
            </button>
        </div>
        <div class="search_field">
            <!-- <input type="search" placeholder="Search for Item"> -->
        </div>
        <div class="export_group">
            <!-- <button type="button" class="btn btn-success" data-toggle="button" aria-pressed="false" autocomplete="off">
                Quotation
            </button> -->
        </div>
        <div class="parent_data_sort">
            <div class="input_select_item">
                <select name="" id="">
                    <option value="POS">POS</option>
                    <option value="Management" selected>Management</option>
                </select>
            </div>
        </div>
    </div>
    <div class="context_bar">

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
                    <th scope="col">Remove</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">#</th>
                    <td class="product-name">
                        <div class="prod_search_elem">
                            <input autocomplete="off" type="text" onfocus="pos_obj.open_search_display()" onblur="pos_obj.close_search_display()" onkeyup="pos_obj.get_item()">
                            <div class="search_display">
                                <div class="no_item">
                                    <p>No items to select from...</p>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="quantity">
                        <input type="number" min=1 value="0" onchange="pos_obj.render_sub_sum()">
                    </td>
                    <td class="price"></td>
                    <td></td>
                    <td onclick="pos_obj.remove_product()">
                        <img src="http://hilltop2.local/res/images/icons/remove_product.png" alt="">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="sale_action">
        <div class="sale_details">
            <!-- <div class="elem_group">
                <p>Quantity</p>
                <p id="sale_price">0</p>
            </div> -->
            <div class="elem_group">
                <p>Amount</p>
                <p id="sale_Amount" >0</p>
            </div>
        </div>
        <div class="sale_action_btn">
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="pos_obj.confirm_sale()">Confirm Sale</button>
            <div class="make_payment">
                <div class="elm_pay">
                    <div class="input_group">
                        <p>Balance:</p>
                        <p id="rem_balance">0</p>
                    </div>
                    <div class="input_group">
                        <p>Input Payment:</p>
                        <input type="number" name="amount_payed" min=0 value="0">
                    </div>
                    <div class="input_group">
                        <p>Payment Method:</p>
                        <select name="payment_method" id="">
                            <option value="Cash">Cash</option>
                            <option value="M-Pesa">M-Pesa</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="pos_obj.make_payment()">Make Payments</button>
            </div>
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="pos_obj.toggle_transactions()">View Transactions</button>
        </div>
        <div class="transactions">
        </div>
    </div>
</div>
<div id="dev_error_display">

</div>