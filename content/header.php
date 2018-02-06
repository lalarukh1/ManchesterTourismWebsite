<?php
session_start();
if (array_key_exists('username', $_SESSION) && array_key_exists('password', $_SESSION)) {
    $username = $_SESSION['username'];
    
} else {
    header('Location: ../content/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title> Manchester </title>
        <link rel="stylesheet" type="text/css" href="../assets/css/stylet.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<header>
<body>

<div id ="mainwrapper">
<div id= "backtotop">
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
<script>
window.onscroll = function() {scrollFunction()};
</script> 
</div>

    
    <div id = "logo">
    <a href="../index.php"><img src="../assets/images/logo.png" alt= "Logo of Manchester tourism site" accesskey="l"/></a>
    </div>
    
    <nav id= "mainnav">
    <div id= "nav">
    <ul>
    <li> <a href="../index.php"> Home </a> </li>
    <li> <a href="../content/activities.php"> Activities </a> </li>
    <li> <a href="../content/managebook.php "> My bookings</a> </li>
    <li> <a href="../content/credits.php "> Credits </a> </li>
    </ul>
    </div>
    </nav>
    <div id= "rightstuff">
    <div id = "socialmedia">
    <a href="../index.php"><img src="../assets/images/facebook.png" alt= "Facebook link" accesskey="f"/></a>
    <a href="../index.php"><img src="../assets/images/twitter.png" alt= "Twitter link" accesskey="t"/></a>
    <a href="../index.php"><img src="../assets/images/instagram.png" alt= "Instagram link" accesskey="i"/></a>
    </div>
    <div id = "userinfo">
    <div class="dropdown">
    <a href="../index.php"><img src="../assets/images/businessman.png" alt= "Logged in user" accesskey="u"/></a>
    <div class="dropdown-content">
    <a href="../content/managebook.php"> Welcome <?php

$username = $_SESSION['username'];
echo "$username";
?> </a>
    <a href="../content/logout.php">Logout</a>
    </div>
    </div>
    </div>
    <div id= "form">
    <form id= "search" method="POST" action = "../content/search.php">
    <input type= "text" name="Search" id="search" placeholder ="What are you looking for?"/>
    <input type="submit" value=" " />
    </form>
    </div>
    </header>