<?php
    require_once ('../../../App/init.php');
?>
<div id="catalog_form">
    <div class="item_name">
        <p>Name:</p>
        <input type="text" name="product_name">
    </div>
    <div class="product_details">
        <div class="store_details">
            <div class="entry_card">
                <div class="input_group_1">
                    <label for="">Product ID:</label>
                    <input type="text">
                </div>
            </div>
            <div class="entry_card">
                <h3>Stock</h3>
                <div class="input_group_1">
                    <label for="">Current Stock:</label>
                    <input type="text">
                    <input type="checkbox" name="vehicle1" value="Bike"> <span>Allow stock tracking? </span>
                </div>
                <div class="input_group_1">
                    <label for="">Units:</label>
                    <select name="" id="">
                        <option value="">Box</option>
                        <option value="">Can</option>
                    </select>
                    <span>Allow stock tracking? </span>
                </div>
                <div class="input_group_1">
                    <label for="">Stock Limits:</label>
                    <div class="min_max">
                        <div class="min_stock">
                            <label for="">Min</label>
                            <input type="number" name="" id="">
                        </div>
                        <div class="img">

                        </div>
                        <div class="max_stock">
                            <label for="">Max</label>
                            <input type="number" name="" id="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="entry_card">
                <h3>Price</h3>
                <div class="input_group_1">
                    <label for="">Sale Price:</label>
                    <input type="text">
                    <input type="checkbox" name="vehicle1" value="Bike"> <span>Lock price? </span>
                </div>
                <div class="input_group_1">
                    <label for="">Supply Price:</label>
                    <input type="text">
                    <input type="checkbox" name="vehicle1" value="Bike"> <span>Lock price? </span>
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
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>