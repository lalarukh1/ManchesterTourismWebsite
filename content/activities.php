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
    <?php echo breadcrumbs(); ?>
   </ul> 
    </div>    

<section id = "music">
	<h2> Music </h2>
<?php
$sql= "SELECT description, activity_name, activityID FROM activities WHERE description LIKE 'Category:Music%'";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $activityID = $currentrow['activityID'];
 include ('../content/activitypart.php');
    }
}
mysqli_free_result($queryresult);
?>


	<h2> Food and Drink </h2>
<?php
$sql = "SELECT description, activity_name, activityID FROM activities WHERE description LIKE 'Category:Food and Drink%'";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $activityID = $currentrow['activityID'];
 
include ('../content/activitypart.php');
    }
}
mysqli_free_result($queryresult);
?>

	<h2> Sightseeing Tours  </h2>
<?php
$sql = "SELECT description, activity_name, activityID FROM activities WHERE description LIKE 'Category:Sightseeing Tours%'";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $activityID = $currentrow['activityID']; 
include ('../content/activitypart.php');
    }
}
mysqli_free_result($queryresult);
?>

	<h2> Shopping  </h2>
<?php
$sql = "SELECT description, activity_name, activityID FROM activities WHERE description LIKE 'Category:Shopping%'";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $activityID = $currentrow['activityID'];
include ('../content/activitypart.php');
    }
}
mysqli_free_result($queryresult);
?>
	<h2> Events  </h2>
<?php
$sql = "SELECT description, activity_name, activityID FROM activities WHERE description LIKE 'Category:Events%'";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $activityID = $currentrow['activityID']; 
include ('../content/activitypart.php');
    }
}
mysqli_free_result($queryresult);
?>

	<h2> Landmarks </h2>

<?php
$sql = "SELECT description, activity_name, activityID FROM activities WHERE description LIKE 'Category:Landmarks%'";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $activityID = $currentrow['activityID']; 
include ('../content/activitypart.php');
    }
}
mysqli_free_result($queryresult);
?>

</section>

<?php
include('footer.php');
?>