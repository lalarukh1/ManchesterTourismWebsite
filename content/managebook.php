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
    <div id = "wrapper">
    <div id = "outerborder">
    
    <h2> Manage Your Bookings </h2>
    <div id = "innertable">
    <table>
    <tr class="top">
    <td> No. </td>
    <td>Activity Name</td>
    <td>Date of Activity</td>
    <td>No. of tickets </td>
    <td>Price per ticket</td>
    <td>Total Price</td>
    <td>Action </td>
    </tr>
    
    <?php

$username = $_SESSION['username'];
if (isset($_SESSION['username'])) {
    $sql  = "SELECT customerID, username from customers WHERE username = ? ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $cust_ID, $user_name);
    
    if ($stmt) {
        while (mysqli_stmt_fetch($stmt)) {
            $customerID = $cust_ID;
        }
    }
}

$errors = array();

if (array_key_exists('date', $_POST) && array_key_exists('tickets', $_POST) && array_key_exists('activityID', $_POST)) {
    $date       = mysqli_real_escape_string($conn, $_POST['date']);
    $tickets    = mysqli_real_escape_string($conn, $_POST['tickets']);
    $activityID = intval($_POST['activityID']);
    
}

else if (empty($_POST['date']) || empty($_POST['tickets']) || empty($_POST['activityID'])) {
    echo "<p>No new bookings ! </p>";
} else {
    echo "<p>You don't have any bookings !</p>";
}

if (isset($_POST['date']) && isset($_POST['tickets']) && isset($_POST['activityID'])) {
    if (!filter_var($tickets, FILTER_VALIDATE_INT)) {
        $error = "Number of tickets can be a number only !";
        header("Location: ../content/booking.php?error=Number of tickets can be a number only");
    } else {
        /** records that already exist **/
        $sql  = "SELECT b.customerID, b.activityID, b.date_of_activity, b.number_of_tickets 
            FROM booked_activities b WHERE b.customerID = ?
            AND activityID = ? ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $customerID, $activityID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $cust_ID, $act_ID, $act_date, $act_tickets);
        
        if ($stmt) {
            while (mysqli_stmt_fetch($stmt)) {
                $activity_ID    = $act_ID;
                $date_activity  = $act_date;
                $number_tickets = $act_tickets;
                
                $sql = "SELECT b.customerID, b.activityID FROM booked_activities b WHERE b.customerID = '$customerID'
        AND $activityID = '$activity_ID'";
                //echo "$sql";
            }
            if ($activityID != $act_ID) {
                
                $sql  = "INSERT INTO booked_activities (activityID, customerID, date_of_activity, number_of_tickets) 
        values (?,?,?,?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "iisi", $activityID, $customerID, $date, $tickets);
                mysqli_stmt_execute($stmt);
                echo "<p> New booking added ! </p>";
                
            }
            
            else if ($activityID == $activity_ID) {
                
                if ($_POST['date'] == $date_activity && $_POST['tickets'] == $number_tickets) {
                    echo "<p>You have already booked the same number of tickets for this activity for the same date !</p>";
                }
                
                else if ($_POST['date'] != $date_activity || $_POST['tickets'] != $number_tickets) {
                    $sql  = "UPDATE booked_activities SET date_of_activity = ? , number_of_tickets = ?
            WHERE activityID = ? AND customerID = ? ";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "siii", $date, $tickets, $activityID, $customerID);
                    mysqli_stmt_execute($stmt);
                    
                    echo "<p> Your booking has been updated ! </p>";
                    
                }
                
            }
        }
        
    }
}

if (array_key_exists('delete', $_POST) && array_key_exists('activityID', $_POST)) {
    $delete     = mysqli_real_escape_string($conn, $_POST['delete']);
    $activityID = mysqli_real_escape_string($conn, $_POST['activityID']);
}

if (isset($_POST['delete']) && ($_POST['activityID'])) {
    $sql  = "DELETE FROM booked_activities WHERE customerID = ?
			AND activityID = ? ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $customerID, $activityID);
    mysqli_stmt_execute($stmt);
    echo "<p>Your activity has been deleted !</p>";
}

else if (isset($_POST['edit']) && ($_POST['activityID'])) {
    $activityID = mysqli_real_escape_string($conn, $_POST['activityID']);
    header("Location: ../content/booking.php?activityID= " . $activityID);
    
}

if (isset($_SESSION['username'])) {
    $sql  = "SELECT a.activityID, a.activity_name, b.date_of_activity, b.number_of_tickets, a.price, b.customerID 
			FROM activities a, booked_activities b WHERE a.activityID = b.activityID AND 
			b.customerID= ? ORDER BY a.activityID DESC ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $customerID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $act_ID, $act_name, $act_date, $act_tickets, $act_price, $cust_ID);
    $counter = 1;
    
    if ($stmt) {
        while (mysqli_stmt_fetch($stmt)) {
            $activity_name     = $act_name;
            $number_of_tickets = $act_tickets;
            $price             = $act_price;
            $date_of_activity  = $act_date;
            $activityID        = $act_ID;
            
            echo "<tr>";
            echo "<td>  $counter </td>";
            echo "<td>  $activity_name </td>";
            echo "<td> $date_of_activity  </td>";
            echo "<td>  $number_of_tickets  </td>";
            echo "<td>  $price £ </td>";
            
            
            $totalprice = $number_of_tickets * $price;
            echo "<td>  $totalprice £ </td>";
            echo "<td>";
?>
  <form id = "delete" method = "post" action = "..\content\managebook.php">
    <input type="hidden" name="activityID" value= " <?php
            echo $activityID = $act_ID;
?> " />
    <input type="submit" name="edit" value="Edit"/>
    <input type="submit" name="delete" value="Delete"/>
    </form>
    
<?php
            echo "</td>";
            echo "</tr>";
            $counter++;
        }
    }
}
echo "</table>";
echo "</div>";
?>
 
    <h3> <a href = "../content/activities.php"> Back to Browse </a></h3>
    </div>
    
    <div id = "upperotherpeople">
    <h4> See what other people have booked </h4>
    <form id = "otherpeople" method="POST" action = "managebook.php">
    <select name="customers" id = "customer">
    <option selected disabled>Please select a customer</option>
    <?php

/* Selecting and displaying customers from database and keeping the selected value in the menu after submitting
to show user what he/she has selected */

$sql = "SELECT DISTINCT c.username, c.customer_forename, c.customer_surname, b.customerID FROM customers c, booked_activities b
		WHERE c.customerID = b.customerID";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $customerforename = $currentrow['customer_forename'];
        $customersurname  = $currentrow['customer_surname'];
        $customer_ID      = $currentrow['customerID'];
        
        echo "<option value= \"$customer_ID\" >";
        echo $customerforename;
        echo " ";
        echo $customersurname;
        echo " ";
        echo $customer_ID;
        echo " </option>";
    }
}
mysqli_free_result($queryresult);
?>
 
    </select>
    <input type="submit" value="Search"\>  
    </form>
    </div>
    <div id ="outerotherpeople">
    
    <?php
if (isset($_POST['customers'])) {
    $customers = mysqli_real_escape_string($conn, $_POST['customers']);
?>
  <h5> Showing results for <?php
    echo "$customerforename";
?> </h5>
    <table id = "customers">
    <tr class ="top">
    <td>Activity Name</td>
    <td>Date of Activity</td>
    <td>No. of tickets </td>
    <td>Price per ticket</td>
    <td>Total Price</td>
    </tr>
    
<?php
    if (array_key_exists('customers', $_POST)) {
        $customers = mysqli_real_escape_string($conn, $_POST['customers']);
    } else {
        echo "No customer selected";
    }
    if (isset($_POST['customers'])) {
        $sql  = "SELECT c.customer_forename, c.customer_surname, a.activity_name, b.date_of_activity, b.number_of_tickets, a.price, c.customerID 
            FROM activities a, booked_activities b, customers c 
            WHERE a.activityID = b.activityID AND c.customerID = b.customerID
            AND b.customerID = ? ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $customers);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $fore_n, $sur_n, $act_n, $act_dat, $act_numt, $act_price, $custom_ID);
        
        
        if ($stmt) {
            while (mysqli_stmt_fetch($stmt)) {
                $activity_name     = $act_n;
                $number_of_tickets = $act_numt;
                $price             = $act_price;
                $date_of_activity  = $act_dat;
                
                echo "<tr>";
                echo "<td>  $activity_name </td>";
                echo "<td> $date_of_activity  </td>";
                echo "<td>  $number_of_tickets  </td>";
                echo "<td>  $price  </td>";
                
                $totalprice = $number_of_tickets * $price;
                echo "<td>  $totalprice  </td>";
                echo "</tr>";
            }
        }
    }
} else {
    echo "No customer selected";
}
?>
  </div>
    </div>
    <?php
include('footer.php');
?>