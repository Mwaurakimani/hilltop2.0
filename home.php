<?php
require_once "App/init.php";

if(!isset($_SESSION['USER'])){
    //some fields were empty
    header("location:http://" . DOMAIN ."/index.php?logIn=801");
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

    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
    <!-- end render plugins -->

    <!-- site_content -->
    <link rel="stylesheet" type="text/css" href="libs/css/main.css">
    <script data-main="libs/js/main" src="libs/js/require.js"></script>
    <!-- end_site_content -->

    <title>Home</title>
</head>

<body>
    <div id="over_lay_element">
        <div class="overlay_close" onclick="over_lays.render_toggle()">
            <img src="<?php echo ICON_PATH.'close_overlay.png' ?>" alt="">
        </div>
        <div class="overlay_content" onclick="over_lays.render_toggle()">
        </div>
    </div>
    <nav id="home_navigation">
        <div class="logo_elem" onclick="over_lays.render_toggle()">
           <img src="logo.png" alt=""> 
        </div>
        <div class="nav_mid">
            <div class="system_clock">
                <div class="clock_item">
                </div>
                <div class="calender_item">
                </div>
            </div>
            <div class="system_search">
                <div class="search_field">
                    <input type="search" placeholder="Search..." onfocus="search_display.render_display()" onblur="search_display.render_hide()"> 
                </div>
                <div class="search_display_area">
                        
                </div>
            </div>
        </div>
        <div class="nav_end">
            <div class="quick_nav_tabs">
                <div class="icon_holder">
                <img src="<?php echo ICON_PATH.'settings.png' ?>" alt="">
                </div>
                <div class="action_panel">

                </div>
            </div>
            <div class="quick_nav_tabs">
                <div class="icon_holder">
                <img src="<?php echo ICON_PATH.'blue_notification.png' ?>" alt="">
                <span class="notification_chip">12</span>
                </div>
                <div class="action_panel">
                    
                </div>
            </div>
            <div class="quick_nav_tabs">
                <div class="icon_holder">
                <img src="<?php echo ICON_PATH.'blue_user_icon.png' ?>" alt="">
                </div>
                <div class="action_panel">
                    
                </div>
            </div>
        </div>
    </nav>
    <section id="body_container" >
        <div id="nav_tabs_container">

        </div>
        <div id="body_content_container">

        </div>
        <div id="side_bar_container">

        </div>
    </section>
</body>
</html>