<?php
    require_once ('../../../App/init.php');
?>
<table class="table table-striped table-bordered table-sm">
    <thead class="thead-dark">
        <tr>
            <th scope="col">
                <input type="checkbox" class="check_all" name="check_all" onchange="tables.toggle_all_check()">
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
