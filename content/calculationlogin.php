<?php
include('dbconn.php');

$username = htmlspecialchars($_REQUEST['username']);
$pwd =  htmlspecialchars($_REQUEST['password']);
$pass = SHA1($pwd);
function check_password($username, $pwd){
    global $conn;
    $pass = SHA1($pwd);
    $sql = "SELECT customerID from customers where username=? AND password_hash=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $pass); 
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $pwdFromDB);
    echo "Checkpwd: Username $username, Password >>$pass<< OK: >>$pwdFromDB<< <br />";
    if (mysqli_stmt_fetch($stmt)) {
        return $pwdFromDB;
    }
    else {
        return false;
    }
}

session_start();
#takes username from REQUEST and puts into Session
if (array_key_exists('username', $_REQUEST ) && array_key_exists('password', $_REQUEST ) ){
    $ok = check_password($username, $pwd);
    if ($ok) {
        $_SESSION['username'] = $_REQUEST['username'];
		$_SESSION['password'] = $_REQUEST['password'];
		
        //echo "Success: Username $username, Password >>$pwd<< OK: >>$ok<< <br />";
        header('Location: ../index.php');
    }
    else {
        //echo "Failed Username $username, Password >>$pwd<< OK: >>$ok<< <br />";
        header('Location: ../content/login.php?message=Wrong username or password!');
    }
}
else 
{
    //echo "No user!,<br />";
    header('Location: ../content/login.php');
}

?>