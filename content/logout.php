<?php

session_start();

if(array_key_exists('username', $_SESSION )){
    $username = $_SESSION['username'];
    echo "<p>Hello $userName</p>";
    session_unset();
    session_destroy();
}

header('Location: ../content/login.php');


?>
