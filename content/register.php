<?php
	include ('dbconn.php');
	include ('functions.php');
	?>
	<!DOCTYPE html>
	<html lang="en">
    <head>
		<meta charset="utf-8" />
		<title> Manchester </title>
		<link rel="stylesheet" type="text/css" href="../assets/css/stylet.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
	
	<body>
	<div id = "mainreg">
	
	<?php
	$username = $pwd = $pass = $cpwd= $forename = $surname = $postcode = $address1 = $address2 = $dob = " ";
	
	$errors = array();
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmpassword']) 
		&& isset($_POST['forename']) && isset($_POST['surname'])
		&& isset($_POST['postcode']) && isset($_POST['address1']) && isset($_POST['address2']) && isset($_POST['dob'])) 
		{
	$username = mysqli_real_escape_string($conn, $_POST['username']); 
	$pwd = mysqli_real_escape_string($conn, $_POST['password']);
	$pass = SHA1($pwd);
	$cpwd= mysqli_real_escape_string($conn, $_POST['confirmpassword']);
	$forename = mysqli_real_escape_string($conn, $_POST['forename']);
	$surname = mysqli_real_escape_string($conn, $_POST['surname']);
	$postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
	$address1 = mysqli_real_escape_string($conn, $_POST['address1']);
	$address2 = mysqli_real_escape_string($conn, $_POST['address2']);
	$dob = mysqli_real_escape_string($conn, $_POST['dob']);
		}
	

//else if (empty($username) || empty($pwd) || empty($cpwd) || empty($forename ) || empty($surname) || empty($postcode ) 
		//|| empty($address1) || empty($address2 ) || empty($dob ))
	//{	
	//$errors[] = "All fields are required";
	//}
		
		
	if (!empty($username) && !empty($pwd) && !empty($cpwd) && !empty($forename ) && !empty($surname) &&! empty($postcode ) 
		&& !empty($address1) && !empty($address2 ) && !empty($dob ))
	{
       
		
	if (!strlen($username) == 8) {
	$errors[] = "Usernames must include 8 letters or numbers combination";
	}
	
	
	
	if (array_key_exists('username', $_POST )) {
		
		$sql = "SELECT username FROM customers WHERE username = '$username'";
		$queryresult = mysqli_query($conn,$sql);
				if ($queryresult) {
					if ($currentrow = mysqli_fetch_assoc($queryresult)) {
					$currentrow = mysqli_num_rows($queryresult);
					$currentrow = mysqli_fetch_assoc($queryresult);
					$user_name = $currentrow['username'];
						if ($username == $user_name) {
						$errors[] = "Username is already taken, please try another option";
						}
				}
				}
	}
	
	if(!preg_match("/^[a-zA-Z0-9 ]*$/",$username))  {
	$errors[] = "Usernames may contain numbers and letters only";
	}
	
	
	if (!preg_match("/^[a-zA-Z1-9 ]*$/",$pwd)) {
		$errors[] = "Password may only contain letters and numbers";
	}
	
	
	if (strcmp($pwd, $cpwd) != 0) {
	$errors[] = "The passwords entered donot match";
	}
	
	if (!preg_match("/^[a-zA-Z ]*$/",$forename)) {
		$errors[] = "Forename may only contain letters";
	}
	
	if (!preg_match("/^[a-zA-Z ]*$/",$surname)) {
		$errors[] = "Surname may only contain letters";
	}
	
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$postcode)) {
		$errors[] = "Postcode may only contain letters and numbers";
	}
	
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$address1)) {
		$errors[] = "Address may only contain letters and numbers";
	}
	
	if (!preg_match("/^[a-zA-Z0-9 ]*$/",$address2)) {
		$errors[] = "Address may only contain letters and numbers";
	}
	
	
}
	
	if ($errors != NULL) {
		echo "<div id =\"error\">";
       echo "<p><em>The following problem(s) occured:</em></p>\n";
       for ($a=0; $a < count($errors); $a++) {
		   
            echo "$errors[$a] <br />\n";
       }

}
else if ($errors == NULL && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirmpassword']) 
		&& !empty($_POST['forename']) && !empty($_POST['surname'])
		&& !empty($_POST['postcode']) && !empty($_POST['address1']) && !empty($_POST['address2']) && !empty($_POST['dob']) )  
{ 
$sql = "INSERT INTO customers (username, password_hash, customer_forename, customer_surname, customer_postcode, 
	customer_address1, customer_address2, date_of_birth) 
	values (?,?,?,?,?,?,?,?)";
	
	$stmt = mysqli_prepare($conn, $sql); 
	mysqli_stmt_bind_param($stmt, "ssssssss", $username, $pass, $forename, $surname, $postcode, $address1, $address2, $dob);
	//mysqli_stmt_execute($stmt);
	

	if ((mysqli_stmt_execute($stmt))) {
		header("Location: ../content/login.php?message=You have been registered successfuly!");
		
	}
	else {
		echo "Query failed";
	}
mysqli_stmt_close($stmt);
}
	 
	mysqli_close($conn);
	
	?>
	</div>

	<form id = "register" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

	<h3> Customer Details </h3>
	
	<label for="username"> Username * </label>
	<input name="username" type="text"  id = "username"  required> <p> --Minimum 8 characters, may contain letters and numbers </p> 
	
	<label for="password"> Password *</label>
	<input name="password" type="password"  id = "password" required> <p> --Only letters and numbers are allowed in password </p>
	
	<label for="password"> Confirm Password *</label>
	<input name="confirmpassword" type="password"  id = "confirmpassword" required> 
	<p> --Please make sure you entered the password correctly </p>
	
	<label for="forename"> Forename *</label>
	<input name="forename" type="text"  id = "forename"  required> <p> --Only letters are allowed </p>
	
	<label for="surname"> Surname *</label>
	<input name="surname" type="text"  id = "surname"  required> <p> --Only letters are allowed </p>
	
	<label for="postcode"> Postcode *</label>
	<input name="postcode" type="text"  id = "postcode"  required> <p> --Only letters and numbers are allowed </p>
	
	<label for="address1"> Address line 1 *</label>
	<input name="address1" type="text"  id = "address1"  required> <p> --Only letters and numbers are allowed </p>
	
	<label for="address2"> Address line 2 *</label>
	<input name="address2" type="text"  id = "address2"  required> <p> --Only letters and numbers are allowed </p>
	
	<label for="dob"> Date of Birth *</label> 
	<input name="dob" type="date"  id = "dob"  required> <p>  -- Please enter the date in 'yyyy-mm-dd 00:00:00' format </p>
	
	<input type="submit" value = "Confirm Booking"/>
	
	</form>
	</div>
	
	


	