<?php

use Lyricorn\User\User;

require_once "App/init.php";
$userName = null;
$password  = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['userName'];
    $password = $_POST['password'];

    if (empty($userName) || empty($password)) {
        //some fields were empty
        header("location:http://" . DOMAIN ."/index.php?logIn=801");
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

            $password_verify = true;

            if($password_verify){

                $_SESSION['USER'] = $rowUser['userName'];

                header("location:http://" . DOMAIN ."/home.php");
                exit();
            }
        }else{
            //some fields were empty
            header("location:http://" . DOMAIN ."/index.php?logIn=802");
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
    <script src="libs/js/system/index.js" ></script>
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
                        <input type="text" name="userName" onfocus="System_call.method.input_focus()" onfocusout="System_call.method.input_focus_out()">
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
                        <input type="password" name="password" onfocus="System_call.method.input_focus()" onfocusout="System_call.method.input_focus_out()">
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
    </div>
    <?php
    
    if(isset($_GET['logIn'])){
        $errorCode = $_GET['logIn'];

        switch($errorCode){
            case 801:
                //not all fields were Entered
                ?>
                <script>
                    alert("Not all fields were entered");
                </script>
                <?php
                break;
            case 802:
                //not all fields were Entered
                ?>
                <script>
                    alert("User Does Not exist");
                </script>
                <?php
                break;
            default:
                break;
        }
    }
    ?>
</body>

</html>