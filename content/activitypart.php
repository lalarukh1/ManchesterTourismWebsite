<article class= "music">
<div class ="top">
    <?php
        echo "<a href =\"booking.php?activityID=$activityID\"> <img src =\"../assets/images/$activityID.jpg\" alt = \"image about activity\"/>
		</a> ";
?>
</div>
    <div class = "bottom">
        <h3> <?php echo "<a href = \"booking.php?activityID=$activityID\">";
        echo $activity_name = $currentrow['activity_name'];
?> </a></h3>
        <p><?php
        echo shorten($description = $currentrow['description']);
?> </p>
<h4> 
 <?php
        echo "<a href = \"booking.php?activityID=$activityID\"> More </a> ";
?> 
 </h4>
    </div>

</article>

