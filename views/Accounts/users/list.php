<?php
    require_once ('../../../App/init.php');

    $sql = 'SELECT * FROM tbl_users';
    $user_return = $admin->runQuery($sql);
    $user_return->execute();
    $users = $user_return->fetchAll();

    if(empty($users)){
        $data_found = false;
    }else{
        $data_found = true;
    }
?>
<div class="content_body_title">
    <h4>Account</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" onclick="">Accounts</li>
        </ol>
    </nav>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="user_account.render_user_form()">
                Create
            </button>
        </div>
    </div>
    <div class="context_bar">

    </div>
</div>
<div id="user_panel_1">
<?php
    if($data_found){
?>
    <table class="table table-striped table-bordered table-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">
                    <input type="checkbox" class="check_all" name="check_all" onchange="user_table.toggle_all_check()">
                </th>
                <th scope="col">#</th>
                <th scope="col">User ID</th>
                <th scope="col">Name </th>
                <th scope="col">Username </th>
                <th scope="col">ID</th>
                <th scope="col">Modified</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                foreach ($users as $key => $value) {
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
                            echo $value['userID'];
                        ?></p>
                    </td>
                    <td>
                        <p><?php
                            echo $value['firstName']." ".$value['lastName'];
                        ?></p>
                    </td>
                    <td>
                        <p><?php
                            echo $value['username'];
                        ?></p>
                    </td>
                    <td>
                        <p><?php
                            echo $value['IDNumber'];
                        ?></p>
                    </td>
                    <td>
                        <p><?php
                            echo $value['dateModified'];
                        ?></p>
                    </td>
                    <td onclick="user_account.render_update()">
                        <img src="<?php echo ICON_PATH.'edit.png' ?>" alt="">
                    </td>
                    <td onclick="user_account.delete_account(<?php echo $value['userID'] ?>)" >
                        <img src="<?php echo ICON_PATH.'trash.png' ?>" alt="">
                    </td>
                </tr>
            <?php   
                    $i++;
                }
            ?>
        </tbody>
    </table>
<?php
    } else {
?>
    <div class="no_data_found_elem">
        <p>No data was Found...</p>
    </div>
<?php
    }
?>
</div>