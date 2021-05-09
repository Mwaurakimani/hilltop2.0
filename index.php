<?php

use Lyricorn\User\User;

require_once "App/init.php";
$userName = null;
$password  = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $error_data = array(
        "username"=>[],
        "password" => []
    );

    if (empty($userName) || empty($password)) {
       // user does not exist
       array_push($error_data['username'],"Username field is empty");
    }else{
        //test if user name exist
        $user = new User();
        
        $stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userName LIKE ?");
        $stmt->execute(array(
            $userName
        ));

        $rowUser = $stmt->fetch();

        if($rowUser){
            $user_password = $rowUser['password'];

            $password_verify = ($user_password == $password)? true:false;

            if($password_verify){
                $_SESSION['USER'] = $rowUser['username'];

                header("location:http://" . DOMAIN ."/home.php");
                exit();
            }else{
                //invalid password
                array_push($error_data['password'],"Invalid password");
            }
        }else{
            // user does not exist
            array_push($error_data['username'],"User does not exist");
        }

    }
}



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- render plugins -->

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- <script data-main="libs/js/main" src="libs/js/require.js"></script> -->
    <!-- end render plugins -->
    <!-- site_content -->
    <link rel="stylesheet" type="text/css" href="libs/css/index.css">
    <script src="libs/js/system/views/index.js" ></script>
    <script src="libs/js/3rd_party/liveJs.js" ></script>
    <!-- end_site_content -->
    <title>Log In</title>
</head>

<body>
    <div id="log_in_panel_container">
        <div class="log_in_panel">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <h2>SIGN IN</h2>
                <div class="input_group_elem">
                    <label for="userName">USERNAME</label>
                    <div class="input_div username">
                        <div class="par">
                            <img src="res/images/icons/user.png" alt="">
                        </div>
                        <input type="text" required name="userName" onfocus="System_call.method.input_focus()" onfocusout="System_call.method.input_focus_out()" value="<?php if(isset($userName)){ echo $userName;}?>">
                        <div class="par">
                            <!-- <img src="res/images/icons/user.png" alt=""> -->
                        </div>
                    </div>
                </div>
                <div class="input_group_elem">
                    <label for="password">PASSWORD</label>
                    <div class="input_div password">
                        <div class="par">
                            <img src="res/images/icons/key.png" alt="">
                        </div>
                        <input type="password" required name="password" onfocus="System_call.method.input_focus()" onfocusout="System_call.method.input_focus_out()"  value="<?php if(isset($password)){ echo $password;}?>">
                        <div class="par">
                            <!-- <img src="res/images/icons/user.png" alt=""> -->
                        </div>
                    </div>
                </div>
                <button type="submit">SIGN IN</button>
                <hr>
                <a href="">Forgot password?</a>
            </form>
        </div>
       
                <?php
                if(isset($error_data)){
                    if((count($error_data['username']) > 0) || (count($error_data['password']) > 0)){
                        ?>
                        <div class="error_render">
                            <p>Sign In  error</p>
                            <ul>
                                <li>
                                    <P>username:</P>
                                    <ul>
                                        <!-- <li>Empty Field</li> -->
                                        <?php
                                            foreach($error_data['username'] as $error){
                                                ?>
                                                <li><?php echo $error;?></li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <li>
                                    <P>Password</P>
                                    <ul>
                                        <!-- <li>Empty Field</li> -->
                                        <?php
                                            foreach($error_data['password'] as $error){
                                                ?>
                                                <li><?php echo $error;?></li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    <?php
                    }
                }
                ?>
            
    </div>  
</body>

</html>