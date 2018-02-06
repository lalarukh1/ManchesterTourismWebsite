  <?php
include('content/dbconn.php');
include('content/header.php');
if (array_key_exists('username', $_SESSION) && array_key_exists('password', $_SESSION)) {
    $username = $_SESSION['username'];
    
} else {
    header('Location: ../content/login.php');
}
?>
    <section id = "uppersection">
    
    <div id = "banner">
    <h1> <a href = "../index.php"> Welcome to Manchester </a> </h1>
    <a href = "../index.php"><img src = "../assets/images/manchester.jpg" alt = "An image of Manchester city" accesskey = "m"/></a>
    </div>
    
    <nav id = "leftblock">
    <h2> <a href="#">Book Your Activity </a></h2>
    <div class = "contentleftblock">
    <div id = "leftitemsl">
    <p> <?php
echo "<a href = \"../content/search.php?description=Category%3ASightseeing+Tours\"> 
    <img src = \"../assets/images/sightseeing.jpg\" alt = \"Sightseeing activities\"/> Sightseeing Tours </a>";
?> </p>
    <p> <?php
echo "<a href = \"content/search.php?description=Category%3AFood+and+Drink\"> 
    <img src = \"../assets/images/food.jpg\" alt = \"food and drink activities\"/> Food and Drink </a>";
?> </p>
    </div>
    <div id = "middleitemsl">
    <p> <?php
echo "<a href = \"content/search.php?description=Category%3AShopping\"> 
    <img src = \"../assets/images/shopping.jpg\" alt = \"shopping activities\"/> Shopping </a>";
?> </p>
    <p> <?php
echo "<a href = \"content/search.php?description=Category%3AMusic\"> 
    <img src = \"../assets/images/music.jpg\" alt = \"music activities\"/> Music </a>";
?> </p>
    </div>
    <div id= "rightitemsl">
    <p> <?php
echo "<a href = \"content/search.php?description=Category%3ALandmarks\"> 
    <img src = \"../assets/images/landmark.jpg\" alt = \"landmark activities\"/> Landmarks </a>";
?> </p>
    <p> <?php
echo "<a href = \"content/search.php?description=Category%3AEvents\"> 
    <img src = \"../assets/images/event.jpg\" alt = \"events\"/> Events </a>";
?> </p>
    
    </div>
    </div>
    
    </nav>
    
    <nav id = "rightblock">
    <h4><a href="#"> Plan Your Visit </a></h4>
    <div class = "contentrightblock">
    <div id="leftitemsr">
    <p> <a href="https://www.visitmanchester.com/visitor-information/weather"> <img src="../assets/images/cloudy.png"/> <br \> Weather </a></p>
    <p> <a href="https://www.visitmanchester.com/things-to-see-and-do/gateway-to-the-north/map#mappos=53,4774,-2,2327,14"><img src="../assets/images/map.png"/><br \>Maps </a></p>
    <p> <a href="https://www.visitmanchester.com/visitor-information/travel-information/getting-around"><img src="../assets/images/coin.png"/><br \>Currency converter </a></p>
    </div>
    <div id="rightitemsr">
    <p> <a href="https://www.visitmanchester.com/visitor-information/manchester-visitor-information-centre-p23991"><img src="../assets/images/visa.png"/><br \>Visa Guide </a></p>
    <p> <a href="https://www.visitmanchester.com/visitor-information/travel-information/manchester-airport"><img src="../assets/images/flight.png"/><br \>Flights </a></p>
    <p> <a href="https://visit-manchester-shop.myshopify.com/"><img src="../assets/images/touristguide.png"/><br \>Travel guide </a></p>
    </div>
    </div>
    </nav>
    
    </section>
    
    <section id = "whatson">
    <div id = "wrapper1">
    
    <h1> What's On </h1>
    
    
    <form id= "whatsonsearch" method="POST" action = "../content/search.php">
    
    <input type="checkbox" name="december" value="December"/> <label class = "checkbox"> December </label>
    <input type="checkbox" name="january" value="January"/> <label class = "checkbox"> January </label>
    
    <input type="submit" value="Search" />    
    </form>
    </div>
    </section>
    
    <div class = "topsellers">
    
    <?php

$sql         = "SELECT b.activityID, a.activity_name , count(b.activityID) IDcount FROM booked_activities b,
activities a WHERE b.activityID= a.activityID GROUP BY activityID ORDER BY IDcount DESC LIMIT 4";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $activityID    = $currentrow['activityID'];
        $activity_name = $currentrow['activity_name'];
?>
   
    <article id = "topseller">
    <?php
        echo "<a href =\"#\"> <img src =\"../assets/images/$activityID.jpg\" alt = \"image about the most popular article\"/> </a> ";
?>
   <h2> <a href = "#"> Top Seller </a> </h2>
    <div class = "middlecontent">
    <p> <?php
        echo "<a href = \"content\booking.php?activityID=$activityID\"> $activity_name </a>";
?> </p>
    </div>
    <h3> <?php
        echo "<a href = \"content\booking.php?activityID=$activityID\"> More </a> ";
?>  </h3>
    </article>
    
    
    <?php
    }
}
?>
   </div>
    <?php
include('content/footer.php');
?>
   
    </body>
    </html> 