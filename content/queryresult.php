<?php
$queryresult        = mysqli_query($conn, $sql);
    if ($queryresult) {
        while ($currentrow = mysqli_fetch_assoc($queryresult)) {
            $activityID    = $currentrow['activityID'];
            $activity_name = $currentrow['activity_name'];
            $description   = $currentrow['description'];
            $location      = $currentrow['location'];
            $price         = $currentrow['price'];
            include('../content/echopart.php');
        }
    }
?>