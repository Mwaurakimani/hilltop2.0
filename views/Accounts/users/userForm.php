<?php
    require_once ('../../../App/init.php');

    $params = (array) json_decode(file_get_contents('php://input'), TRUE);
    if(isset($params[0])){
        $id = $params[0];

        $sql = 'SELECT * FROM tbl_users WHERE userID = :id';
        $user_return = $admin->runQuery($sql);
        $user_return->execute(array(
            ':id'=>$id
        ));
        $data_found= null;

        $users = $user_return->fetchAll();

        if(empty($users)){
            $data_found = false;
        }else{
            $data_found = true;
            $user = $users[0];
        }
    }else{
        $data_found = false;
    }
?>
<div class="content_body_title">
    <h4>Account</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item active"> <a href="#" onclick="navigation_panel
                                                                                .pre_def_intent('Accounts')
                                                                                .render_body_content(path.Accounts.users + 'list.php',user_init)
                                                                                ;return false" >Account</a></li>
            <?php
                if($data_found){
                    ?>
                    <li class="breadcrumb-item active"> <?php echo $user['firstName']."-".$user['lastName']; ?></li>
                    <?php
                }else{
                    ?>
                    
                    <li class="breadcrumb-item active"> 
                    <?php
                        if($data_found){
                            echo 'new-user';
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
                if($data_found){
                    ?>
                    <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="user_account.update_user(<?php echo $user['userID'] ?>)">
                        Update
                    </button>
                    <?php
                }else{
                    ?>
                     <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="user_account.create_user()">
                        Create
                     </button>
                    <?php
                }
            ?>
           
            
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
                <input type="text" name="userID" disabled value='<?php if($data_found){ echo $user["userID"]; }else{ echo "unset";}?>'>
            </div>
            <div class="input_group sub_holder">
                <div class="input_sub_group">
                    <label for="">First Name :</label>
                    <input type="text"  name="firstName" value='<?php if($data_found){ echo $user["firstName"]; }?>'>
                </div>
                <div class="input_sub_group">
                    <label style="padding-left:5px;" for="">Last Name :</label>
                    <input type="text" name="lastName" value='<?php if($data_found){ echo $user["lastName"]; }?>'>
                </div>
            </div>
            <div class="input_group">
                <label for="">Username :</label>
                <input type="text" name="username" value='<?php if($data_found){ echo $user["username"]; }?>'>
            </div>
            <div class="input_group">
                <label for="">Phone :</label>
                <input type="tel" name="phone" value='<?php if($data_found){ echo $user["email"]; }?>'>
            </div>
            <div class="input_group">
                <label for="">Email :</label>
                <input type="email" name="email" value='<?php if($data_found){ echo $user["email"]; }?>'>
            </div>
            <div class="input_group">
                <label for="">Password :</label>
                <input type="password" name="password" value='<?php if($data_found){ echo $user["firstName"]; }?>'>
            </div>
            <div class="input_group">
                <label for="">ID Number</label>
                <input type="text" name="ID_number" value='<?php if($data_found){ echo $user["IDNumber"]; }?>'>
            </div>
        </div>
        <div class="sub_details">
            <h3>User Detail</h3>
            <div class="input_group">
                <label for="">Status # :</label>
                <select name="Status" id="" >
                    <?php 
                    if(!$data_found){
                         ?>
                         <option value="Active" :selected>Active</option>
                         <option value="Inactive">Inactive</option>
                         <?php
                    }else{
                        $keys = ['Active','Inactive'];
                        $selected = $user['status'];

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
            <div class="input_group">
                <label for="">User-group :</label>
                <select name="userGroup" id="">
                    <?php 
                    if(!$data_found){
                         ?>
                         <option value="Moderator" :selected>Moderator</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                        <option value="SuperUser">Super User</option>
                         <?php
                    }else{
                        $keys = ['Moderator','Manager','Admin','SuperUser'];
                        $selected = $user['userGroup'];

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
        </div>
    </div>
</div>