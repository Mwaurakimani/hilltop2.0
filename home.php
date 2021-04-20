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

    <!-- end render plugins -->

    <!-- site_content -->
    <link rel="stylesheet" type="text/css" href="libs/css/main.css">
    <script data-main="libs/js/main" src="libs/js/require.js"></script>
    <!-- end_site_content -->

    <title>Home</title>
</head>

<body>
    <div id="over_lay_element">
        
    </div>
    <nav id="home_navigation">
        <div class="logo_elem" onclick="">
            
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