<article class= "articlesearch">
    <div class ="leftsearch">
    <?php
echo "<a href =\"../content/booking.php?activityID=$activityID\"> 
    <img src =\"../assets/images/$activityID.jpg\" alt = \"image about this activity\"/> </a> ";
?>
   
    </div>
    <div class = "rightsearch">
    <h2><?php
echo "<a href = \"../content/booking.php?activityID=$activityID\">";
echo $activity_name;
?> <br />
    <?php
echo $location;
?> </a></h2>
    <h4> <?php
echo $price;
?> £ </h4>
    <p><?php
echo shorten($description);
?> </p>
    <h3><?php
echo "<a href = \"../content/booking.php?activityID=$activityID\"> More </a> ";
?></h3>
    </div>
    </article> 