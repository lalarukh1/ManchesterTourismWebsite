 <?php
include('header.php');
include('dbconn.php');
include('functions.php');
if (array_key_exists('username', $_SESSION) && array_key_exists('password', $_SESSION)) {
    $username = $_SESSION['username'];
    
} else {
    header('Location: ../content/login.php');
}
?>
 
    <div class ="breadcrumb">
    <ul>
    <?php
echo breadcrumbs();
?>
   </ul> 
    </div>
    
<?php

$activityID = 0;
// Check ActivityID is an integer only

if (array_key_exists('activityID', $_REQUEST)) {
    $activityID = intval($_REQUEST['activityID']);
} else {
    echo "No id!,<br />";
}


if ($activityID) {
    
    $sql  = "SELECT activity_name, price, description, location, activityID FROM activities where activityID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $activityID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $act_name, $act_price, $act_desc, $act_loc, $act_ID);
    
    if ($stmt) {
        while (mysqli_stmt_fetch($stmt)) {
            $activityID    = $act_ID;
            $activity_name = $act_name;
            $description   = $act_desc;
            $price         = $act_price;
            $location      = $act_loc;
            
?>
     
    <div id = "leftcolumn">
    <div id ="wrapper">
    <h1> <a href = "#"> <?php
            echo "$activity_name";
?> </a></h1>
    
    <?php
            echo "<img src =\"../assets/images/$activityID.jpg\" alt = \"whole description about the activity\"/>";
?>
   <p>  <?php
            echo "$description";
?> </p>
    <h2> <?php
            echo "Price : $price";
?> £ </h2>
    <h3> <?php
            echo "Location: $location";
?> </h3>
    
<?php
        }
    } 
	else 
	{
        echo "ID:$activityID is not in the database</p>";
    }
    
}
?>
  </div>
    </div>
    
    <div id ="rightcolumn">
	<?php
	if (!empty($_GET['message'])) {
    $message = $_GET['message'];
    echo "<h3>$message</h3>";
	}
	?>

    <h2> Please Enter Your Booking Details </h2>
    <form id = "booking" method="post" action = "../content/managebook.php">
    <h4> Booking Details </h4>
    <input type="hidden" name="activityID" value="<?php
echo $activityID = $act_ID;
?>" />
    <label for="date"> Date (yyyy-mm-dd 00:00:00) </label>
    <input name="date" type="date" id = "date"  required>
    <label for="tickets"> No. of Tickets</label>
    <input name="tickets" type="number" id = "tickets"  required>
    <input type="submit" value="Confirm"/>
    </form>
    <h5> <a href="activities.php">Back to Browse </a></h5>
    </div>
    
    <?php
include('footer.php');
?> 