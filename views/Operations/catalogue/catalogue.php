<?php
    require_once ('../../../App/init.php');
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
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                Add
            </button>
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                Update
            </button>
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                Delete
            </button>
        </div>
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
    </div>
    <div class="context_bar">

    </div>
</div>
<div class=".table_view"  id="catalog_panel_1">
    <div id="catalog_form">
        <div class="item_name">
            <p>Name:</p>
            <input type="text" name="product_name">
        </div>
        <div class="product_details">
            
        </div>
    </div>
</div>
