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
    
    <div id = "topstuff">
    <div id = "keyword"> 
    <p>   </p>
    </div>
<?php
//$search = $january= $december = " "; 
$results = array();
?>
 
    <div id = "refine">
    <p> Refine your search </p>
    
    <form id = "refinesearch" method="POST" action = "../content/search.php">
    
    <label for="price"> Price </label>

    <select name="price" id = "price">
    <option selected disabled>Please select a price</option>
    <?php
/* Selecting price values from database and displaying a price range in drop down menu*/

$sql         = "SELECT DISTINCT price FROM activities";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $price = $currentrow['price'];
    }
?>
 
<?php
    echo " <option value=\"1 and 20\" > 1£ - 20£ </option> ";
    echo " <option value=\"20 and 40\" >20£ - 40£ </option> ";
    echo " <option value=\"40 and 60\" >40£ - 60£ </option> ";
    echo " <option value=\"60 and 80\" > 60£ - 80£ </option> ";
    echo " <option value=\"80 and 100\" > 80£ - 100£ </option> ";
    
}
mysqli_free_result($queryresult);
?>
  </select>
    
    <label for="location"> Location </label>

    <select name="location" id = "location">
    <option selected disabled>Please select a location</option>
<?php
/*displaying location values from database into the drop down list */
$sql         = "SELECT DISTINCT location FROM activities";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $location = $currentrow['location'];
        echo "<option value= \"$location\" >";
        echo $location = $currentrow['location'];
        "</option>";
    }
}
mysqli_free_result($queryresult);
?>

   </select>
    
    <label for="category"> Category </label>
    <select name="description" id = "description">
    <option selected disabled>Please select a category</option>
<?php
/* displaying categories extracted from the text in description column in the drop down menu */
$sql         = "SELECT description FROM activities";
$queryresult = mysqli_query($conn, $sql);
if ($queryresult) {
    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
        $description = $currentrow['description'];
    }
    echo "<option value=\"Category:Sightseeing Tours\"> Sightseeing Tours </option>
    <option value=\"Category:Food and Drink\"> Food and Drink </option>
    <option value=\"Category:Landmarks\"> Landmarks </option>
    <option value=\"Category:Shopping\"> Shopping </option>
    <option value=\"Category:Music\"> Music  </option>
    <option value=\"Category:Events\"> Events </option> ";
}
mysqli_free_result($queryresult);
?>
  </select>
   <input type="submit" value="Search" name = "submitsearch"\>  
   </form>

<?php

/* checking search field from the top search bar in header */
if (array_key_exists('Search', $_POST)) {
    $search = mysqli_real_escape_string($conn, $_POST['Search']);
}
if (!empty($search)) {
    //echo " for \"$search\" "; 
    $_SESSION['search'] = $search;
}
/* Getting values from the form with checkboxes from the whats on section on index page*/
else if (array_key_exists('december', $_POST) && array_key_exists('january', $_POST)) {
    $december = mysqli_real_escape_string($conn, $_POST['december']);
    $january  = mysqli_real_escape_string($conn, $_POST['january']);
    
    if (!empty($december) && !empty($january)) {
        $_SESSION['december'] = $december;
        $_SESSION['january']  = $january;
    }
    
}

else if (array_key_exists('december', $_POST)) {
    $december = mysqli_real_escape_string($conn, $_POST['december']);
    if (!empty($december)) {
        $_SESSION['december'] = $december;
    }
}

else if (array_key_exists('january', $_POST)) {
    $january = mysqli_real_escape_string($conn, $_POST['january']);
    if (!empty($january)) {
        $_SESSION['january'] = $january;
    }
}

/* Getting data from fields of search page filters, the three drop down lists */
if (array_key_exists('price', $_POST) && array_key_exists('location', $_POST) && array_key_exists('description', $_POST)) {
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
} else if (array_key_exists('price', $_POST) && array_key_exists('location', $_POST)) {
    $price    = mysqli_real_escape_string($conn, $_POST['price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
} else if (array_key_exists('price', $_POST) && array_key_exists('description', $_POST)) {
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
} else if (array_key_exists('description', $_POST) && array_key_exists('location', $_POST)) {
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
} else if (array_key_exists('price', $_POST)) {
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
} else if (array_key_exists('location', $_POST)) {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
}

else if (array_key_exists('description', $_POST)) {
    $description = mysqli_real_escape_string($conn, $_POST['description']);
}
?> 
    </div>
    </div>
    <div id = "optionsselected">
    <h2> Search Results <?php

if (!empty($search)) {
    echo " for \"$search\" ";
    $_SESSION['search'] = $search;
    
}

else if (!empty($january) && !empty($december)) {
    echo " for \"$december\" and \"$january\" activities ";
} else if (!empty($january)) {
    $search = " ";
    echo " for \"$january\" activities ";
} else if (!empty($december)) {
    $search = " ";
    echo " for \"$december\" activities ";
}

?> </h2>
    
<?php

/* Querying database on the basis of keywprd typed in header search bar and displaying results while iterating */
if (isset($_POST['Search'])) {
    $sql  = "SELECT description, price, activity_name, activityID, location FROM activities
            WHERE activity_name LIKE CONCAT('%',?,'%') OR description LIKE CONCAT('%',?,'%') OR location LIKE CONCAT('%',?,'%')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $desc, $pric, $name, $acid, $loca);
    if ($stmt) {
        while (mysqli_stmt_fetch($stmt)) {
            $activityID    = $acid;
            $activity_name = $name;
            $location      = $loca;
            $price         = $pric;
            $description   = $desc;
            include('../content/echopart.php');
        }
    }
}

/* Querying database on the basis of whats on menus on the main page and displaying requested results while iterating.
Note: The value of date comes from description */
else if (isset($_POST['december']) && isset($_POST['january'])) {
    $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
            WHERE description LIKE '%DEC%' OR description LIKE '%JAN%' ";
    $_SESSION['search'] = false;
    include ('../content/queryresult.php');
} else if (isset($_POST['december'])) {
    $sql                 = "SELECT description, price, activity_name, activityID, location FROM activities 
            WHERE description LIKE '%DEC%'";
    $_SESSION['search']  = false;
    $_SESSION['january'] = false;
    include ('../content/queryresult.php');
}

else if (isset($_POST['january'])) {
    $sql                  = "SELECT description, price, activity_name, activityID, location FROM activities 
            WHERE description LIKE '%JAN%' ";
    $_SESSION['search']   = false;
    $_SESSION['december'] = false;
    include ('../content/queryresult.php');
}

/* Querying database on the basis of search page filters with three menus and displaying requested results while iterating.
Note: The value of category comes from description */


if (isset($_POST['submitsearch']) && empty($_POST['price']) && empty($_POST['location']) && empty($_POST['description'])) {
    $sql         = "SELECT * FROM activities";
    include ('../content/queryresult.php');
}

if (!empty($_POST['price']) && !empty($_POST['location']) && !empty($_POST['description'])) {
    $search   = $_SESSION['search'];
    $december = $_SESSION['december'];
    $january  = $_SESSION['january'];
    if ($search != NULL) {
        $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                WHERE price BETWEEN $price AND location = \"$location \"AND description LIKE '$description%' AND description LIKE \"%$search%\" ";
        //$results[] = " $price $location $description $search ";
    }
    
    else if ($december != NULL || $january != NULL) {
        $_SESSION['search'] = false;
        if ($december != NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND location = \"$location \"AND description LIKE '$description%' AND description LIKE \"%DEC%\" 
                    OR price BETWEEN $price AND location = \"$location \"AND description LIKE '$description%' AND description LIKE \"%JAN%\" ";
        } else if ($january == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND location = \"$location \"AND description LIKE '$description%' AND description LIKE \"%DEC%\" ";
        } else if ($december == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND location = \"$location \"AND description LIKE '$description%' AND description LIKE \"%JAN%\" ";
        } else {
            echo "No option selected";
        }
    } else {
        echo "Choosen Dec Jan options didnt work";
    }
    
    include ('../content/queryresult.php');
}
/** check for two fields, price and location**/
else if (!empty($_POST['price']) && !empty($_POST['location'])) {
    $search   = $_SESSION['search'];
    $december = $_SESSION['december'];
    $january  = $_SESSION['january'];
    if ($search != NULL) {
        $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                WHERE price BETWEEN $price AND location = \"$location \" AND description LIKE \"%$search%\"";
    }
    
    else if ($december != NULL || $january != NULL) {
        $_SESSION['search'] = false;
        if ($december != NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND location = \"$location \" AND description LIKE \"%DEC%\" 
                    OR price BETWEEN $price AND location = \"$location \" AND description LIKE \"%JAN%\" ";
        } else if ($january == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND location = \"$location \" AND description LIKE \"%DEC%\" ";
        } else if ($december == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND location = \"$location \" AND description LIKE \"%JAN%\" ";
        } else {
            echo "No option selected";
        }
        
        
    } else {
        echo "Dec jan options didnt work";
    }
    
   include ('../content/queryresult.php');
}

/** checking for two fields, price and description **/

else if (!empty($_REQUEST['price']) && !empty($_REQUEST['description'])) {
    $search   = $_SESSION['search'];
    $december = $_SESSION['december'];
    $january  = $_SESSION['january'];
    if ($search != NULL) {
        $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                WHERE price BETWEEN $price AND description LIKE '$description%' AND description LIKE \"%$search%\" ";
    } else if ($december != NULL || $january != NULL) {
        $_SESSION['search'] = false;
        if ($december != NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND description LIKE '$description%' AND description LIKE \"%DEC%\" 
                    OR price BETWEEN $price AND description LIKE '$description%' AND description LIKE \"%JAN%\" ";
        } else if ($january == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND description LIKE '$description%' AND description LIKE \"%DEC%\" ";
        } else if ($december == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND description LIKE '$description%' AND description LIKE \"%JAN%\" ";
        } else {
            echo "No option selected";
        }
        
    } else {
        echo "Dec jan options didnt work";
    }
    
    include ('../content/queryresult.php');
}

/** checking if two fields, description and location are selected **/

else if (!empty($_POST['description']) && !empty($_POST['location'])) {
    $search   = $_SESSION['search'];
    $december = $_SESSION['december'];
    $january  = $_SESSION['january'];
    if ($search != NULL) {
        $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                WHERE description LIKE '$description%' AND location = \"$location \" AND description LIKE \"%$search%\" ";
    } else if ($december != NULL || $january != NULL) {
        $_SESSION['search'] = false;
        if ($december != NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE description LIKE '$description%' AND location = \"$location \" AND description LIKE \"%DEC%\" 
                    OR description LIKE '$description%' AND location = \"$location \" AND description LIKE \"%JAN%\" ";
        } else if ($january == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE description LIKE '$description%' AND location = \"$location \" AND description LIKE \"%DEC%\" ";
        } else if ($december == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE description LIKE '$description%' AND location = \"$location \" AND description LIKE \"%JAN%\" ";
        } else {
            echo "No option selected";
        }
    } else {
        echo "Dec jan options didnt work";
    }
    
    include ('../content/queryresult.php');
}

/** if only price is selected to filter results **/

else if (!empty($_POST['price'])) {
    $search   = $_SESSION['search'];
    $december = $_SESSION['december'];
    $january  = $_SESSION['january'];
    if ($search != NULL) {
        $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                WHERE price BETWEEN $price AND description LIKE \"%$search%\"";
    } else if ($december != NULL || $january != NULL) {
        $_SESSION['search'] = false;
        if ($december != NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND description LIKE \"%DEC%\" 
                    OR price BETWEEN $price AND description LIKE \"%JAN%\" ";
        } else if ($january == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND description LIKE \"%DEC%\" ";
        } else if ($december == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE price BETWEEN $price AND description LIKE \"%JAN%\" ";
        } else {
            echo "No option selected";
        }
        
    } else {
        echo "Dec jan options didnt work";
    }
    
    include ('../content/queryresult.php');
    mysqli_free_result($queryresult);
}

/** checking if description comes from the main index page**/
else if (array_key_exists('description', $_GET)) {
    $description = mysqli_real_escape_string($conn, $_REQUEST['description']);
    $sql         = "SELECT description, price, activity_name, activityID, location FROM activities 
            WHERE description LIKE '$description%' ";
    include ('../content/queryresult.php');
    mysqli_free_result($queryresult);
}

/** checking if only description is selected from the drop down menu as a filter **/

else if (!empty($_POST['description'])) {
    $search   = $_SESSION['search'];
    $december = $_SESSION['december'];
    $january  = $_SESSION['january'];
    if ($search != NULL) {
        $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE description LIKE '$description%' AND description LIKE \"%$search%\" ";
    }
    
    else if ($december != NULL || $january != NULL) {
        $_SESSION['search'] = false;
        if ($december != NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                        WHERE description LIKE '$description%' AND description LIKE \"%DEC%\" 
                        OR description LIKE '$description%' AND description LIKE \"%JAN%\" ";
        } else if ($december != NULL && $january == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                        WHERE description LIKE '$description%' AND description LIKE \"%DEC%\" ";
        } else if ($december == NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                        WHERE description LIKE '$description%' AND description LIKE \"%JAN%\" ";
        } else {
            echo "No option selected";
        }
    } else {
        echo "Dec jan options didnt work";
    }
    
    include ('../content/queryresult.php');
    mysqli_free_result($queryresult);
}


else if (array_key_exists('description', $_GET)) {
    $description = mysqli_real_escape_string($conn, $_REQUEST['description']);
    $sql         = "SELECT description, price, activity_name, activityID, location FROM activities 
            WHERE description LIKE '$description%' ";
    include ('../content/queryresult.php');
    mysqli_free_result($queryresult);
}

/** checking if only location is applied as filter **/

else if (!empty($_REQUEST['location'])) {
    $search   = $_SESSION['search'];
    $december = $_SESSION['december'];
    $january  = $_SESSION['january'];
    
    if ($search != NULL) {
        $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                WHERE location = \"$location\" AND description LIKE \"%$search%\" ";
    }
    
    else if ($december != NULL || $january != NULL) {
        $_SESSION['search'] = false;
        if ($december != NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE location = \"$location\" AND description LIKE \"%DEC%\" OR location = \"$location\" AND description LIKE \"%JAN%\" ";
        } else if ($december != NULL && $january == NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE location = \"$location\" AND description LIKE \"%DEC%\" ";
        } else if ($december == NULL && $january != NULL) {
            $sql = "SELECT description, price, activity_name, activityID, location FROM activities 
                    WHERE location = \"$location\" AND description LIKE \"%JAN%\" ";
        } else {
            echo "No option selected";
        }
        
    } else {
        echo "Dec jan options didnt work";
    }
    
    include ('../content/queryresult.php');
    mysqli_free_result($queryresult);
}
?>
  </div>
<?php
include('../content/footer.php');
?> 