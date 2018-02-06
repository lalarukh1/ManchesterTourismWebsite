<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title> Manchester </title>
        <link rel="stylesheet" type="text/css" href="../assets/css/stylet.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    
    <?php
include('dbconn.php');
session_start();
if (array_key_exists('username', $_SESSION)) {
    header('Location: ../index.php');
}
?>
 
    <div id ="outerwrapper">
    <div id = "block">
    <div id = "loginform">
    <?php
if (!empty($_GET['message'])) {
    $message = $_GET['message'];
    echo "<h3>$message</h3>";
}
?>
  <h1> Please enter your login details </h1>
    <form id = "login" method="POST" action = "../content/calculationlogin.php">
    <label for="username"> Username </label>
    <input name="username" type="text"  id = "username">
    
    <label for="password"> Password </label>
    <input name="password" type="password"  id = "password">
    
    <input type="submit" value = "Login" />
    </form>
    </div>
    <p> If you are a new customer, Please Register. </p>
    <h2> <a href ="../content/register.php"> Register </h2>
    </div>
    </div> 