<?php
require_once "App/init.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(! isset($_SESSION['USER'])){
    header("location:http://" . DOMAIN ."/index.php");
    exit();
}

// if(!isset($_SESSION['USER'])){
//     //some fields were empty
//     header("location:http://" . DOMAIN ."/index.php?logIn=801");
// }
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
            <div class="system_search">
                <div class="search_field">
                    <input type="search" placeholder="Search..." onfocus="search_display.render_display()" onblur="search_display.render_hide()"> 
                </div>
                <div class="search_display_area">
                        
                </div>
            </div>
            <div class="system_clock">
                <div class="clock_item">
                </div>
                <div class="calender_item">
                </div>
            </div>
        </div>
        <div class="nav_end" id="nav_end">
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
                <div class="action_panel user_pan">
                    <button><?php echo($_SESSION['USER']); ?></button>
                    <button onclick="third_section.log_out()">Log out</button>
                </div>
            </div>
        </div>
    </nav>
    <section id="body_container" >
        <div id="nav_tabs_container">
            <div class="nav_group">
                <div class="group_head">
                    <h3 style="color: #2ECC71;">Home</h3>
                </div>
                <div class="group_body">
                    <ul>
                        <li onclick="navigation_panel.pre_def_intent('Account').render_body_content(path.Home.shop+'view.php',$('.item_content'));">
                            <img src="<?php echo ICON_PATH.'shop.png' ?>" alt="">
                            <p>Shop</p>
                        </li>
                        <li>
                            <img src="<?php echo ICON_PATH.'dashboard.png' ?>" alt="">
                            <p>Dashboard</p>
                        </li onclick="navigation_panel.pre_def_intent('Account').render_body_content(path.Home.Dashboard+'Dashboard.php',$('.item_content'));">
                    </ul>
                </div>
            </div>

            <div class="nav_group">
                <div class="group_head">
                    <h3 style="color:#E67E22">Operations</h3>
                </div>
                <div class="group_body">
                    <ul>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Operations.POS+'POS.php',$('.item_content').init(pos_init));">
                            <img src="<?php echo ICON_PATH.'pos.png' ?>" alt="">
                            <p>P.O.S</p>
                        </li>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Operations.stockControl+'stockControl.php',$('.item_content').init(stock_handler_init));">
                            <img src="<?php echo ICON_PATH.'stock.png' ?>" alt="">
                            <p>Stock Control</p>
                        </li>
                        <li  onclick="navigation_panel.get_intent().render_body_content(path.Operations.catalogue + 'list.php', catalogue_init);">
                            <img src="<?php echo ICON_PATH.'catalogue.png' ?>" alt="">
                            <p>Catalogue</p>
                        </li>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Operations.sales+'sales.php',$('.item_content').init(sale_init));">
                            <img src="<?php echo ICON_PATH.'sales.png' ?>" alt="">
                            <p>Sales</p>
                        </li>
                        <!-- <li onclick="navigation_panel.get_intent().render_body_content(path.Operations.transactions+'transactions.php',$('.item_content').init(catalogue_init));">
                            <img src="<?php echo ICON_PATH.'transaction.png' ?>" alt="">
                            <p>Transactions</p>
                        </li> -->
                    </ul>
                </div>
            </div>

            <div class="nav_group">
                <div class="group_head">
                    <h3 style="color:#3498DB">Management</h3>
                </div>
                <div class="group_body">
                    <ul>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Management.Notification +'notifications.php',$('.item_content').init(notification_init));">
                            <img src="<?php echo ICON_PATH.'mail.png' ?>" alt="">
                            <p>Notifications</p>
                        </li>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Management.reports +'Reports.php',$('.item_content').init(reports_init));">
                            <img src="<?php echo ICON_PATH.'report.png' ?>" alt="">
                            <p>Reports</p>
                        </li>
                        <!-- <li onclick="navigation_panel.pre_def_intent('Account').render_body_content(path.Management.customization+'customization.php',$('.item_content'));">
                            <img src="<?php echo ICON_PATH.'custom.png' ?>" alt="">
                            <p>Customization</p>
                        </li>
                        <li onclick="navigation_panel.pre_def_intent('Account').render_body_content(path.Management.mediaManagement+'mediaManagement.php',$('.item_content'));">
                            <img src="<?php echo ICON_PATH.'mediaManager.png' ?>" alt="">
                            <p>Media Management</p>
                        </li> -->
                    </ul>
                </div>
            </div>

            <div class="nav_group">
                <div class="group_head">
                    <h3 style="color:#E74C3C">Account</h3>
                </div>
                <div class="group_body">
                    <ul>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Accounts.account + 'userForm.php', user_init);">
                            <img src="<?php echo ICON_PATH.'users.png' ?>" alt="">
                            <p>Account</p>
                        </li>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Accounts.users + 'list.php', user_init);">
                            <img src="<?php echo ICON_PATH.'myAccount.png' ?>" alt="">
                            <p>Accounts</p>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="nav_group">
                <div class="group_head">
                    <h3>User group</h3>
                </div>
                <div class="group_body">
                    <ul>
                        <li>
                            <img src="<?php echo ICON_PATH.'settings.png' ?>" alt="">
                            <p>Admin</p>
                        </li>
                        <li>
                            <img src="<?php echo ICON_PATH.'settings.png' ?>" alt="">
                            <p>Super User</p>
                        </li>
                    </ul>
                </div>
            </div> -->
            
        </div>
        <div id="body_content_container">
            <div id="item_content">

                
                

            </div>
        </div>
        <div id="side_bar_container">
            
        </div>
    </section>
    
</body>
</html>
























































                        <!-- <li onclick="navigation_panel.get_intent().render_body_content(path.Operations.customer+'customer.php',$('.item_content').init(catalogue_init));">
                            <img src="<?php echo ICON_PATH.'customer.png' ?>" alt="">
                            <p>Customers</p>
                        </li>
                        <li onclick="navigation_panel.get_intent().render_body_content(path.Operations.vendor+'vendor.php',$('.item_content').init(catalogue_init));">
                            <img src="<?php echo ICON_PATH.'vendor.png' ?>" alt="">
                            <p>Vendors</p>
                        </li> -->