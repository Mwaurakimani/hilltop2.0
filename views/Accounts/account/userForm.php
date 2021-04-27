<?php
    require_once ('../../../App/init.php');
?>
<div class="content_body_title">
    <h4>Account</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Account</li>
        </ol>
    </nav>
</div>
<div class="activity_bar">
    <div class="action_bar">
        <div class="btn_activity_bar">
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="user_account">
                Create
            </button>
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                Update
            </button>
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                Delete
            </button>
        </div>
    </div>
    <div class="context_bar">

    </div>
</div>
<div id="catalog_panel_1">
    <div id="user_input_form">
        <div class="main_details">
            <h3>User Detail</h3>
            <div class="input_group">
                <label for="">User # :</label>
                <input type="text">
            </div>
            <div class="input_group sub_holder">
                <div class="input_sub_group">
                    <label for="">First Name :</label>
                    <input type="text">
                </div>
                <div class="input_sub_group">
                    <label style="padding-left:5px;" for="">Last Name :</label>
                    <input type="text">
                </div>
            </div>
            <div class="input_group">
                <label for="">Username :</label>
                <input type="text">
            </div>
            <div class="input_group">
                <label for="">Email :</label>
                <input type="text">
            </div>
            <div class="input_group">
                <label for="">Password :</label>
                <input type="text">
            </div>
            <div class="input_group">
                <label for="">ID Number</label>
                <input type="text">
            </div>
        </div>
        <div class="sub_details">
            <h3>User Detail</h3>
            <div class="input_group">
                <label for="">Status # :</label>
                <select name="" id="">
                    <option value="">Active</option>
                    <option value="">Inactive</option>
                </select>
            </div>
            <div class="input_group">
                <label for="">User-group :</label>
                <select name="" id="">
                    <option value="">Moderator</option>
                    <option value="">Manager</option>
                    <option value="">Admin</option>
                    <option value="">Super User</option>
                </select>
            </div>
        </div>
    </div>
</div>