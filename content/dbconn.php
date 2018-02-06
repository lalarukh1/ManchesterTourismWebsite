<?php

	$config = parse_ini_file('config.ini'); 
    $conn = mysqli_connect('localhost', $config['username'],$config['password'],$config['dbname']) 
    or die("Could Not Connect to MySQL!");
	
	mysqli_select_db($conn,"travel")
	or die("Could Not Open Database:".mysqli_error());
	//echo "It works";

?>
