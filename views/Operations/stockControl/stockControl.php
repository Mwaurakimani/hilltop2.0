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
                <th scope="col">Status</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for ($i=1; $i < 6; $i++) { 
            ?>
                <tr class="selected">
                    <th scope="col">
                        <input type="checkbox" class="check_all">
                    </th>
                    <td scope="row">
                        <p><?php echo ($i) ?></p>
                    </td>
                    <td style="overflow: auto;">
                        <p>123</p>
                    </td>
                    <td>
                        <p>chrome</p>
                    </td>
                    <td>
                        <p>100</p>
                    </td>
                    <td>
                        <p>Status</p>
                    </td>
                    <td>
                        <img src="<?php echo ICON_PATH.'edit.png' ?>" alt="">
                    </td>
                    <td>
                        <img src="<?php echo ICON_PATH.'trash.png' ?>" alt="">
                    </td>
                </tr>
            <?php   
                }
            ?>
        </tbody>
    </table>
</div>