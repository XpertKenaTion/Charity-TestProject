<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config1.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM donor WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $email = $row["email"];
                $homeaddress = $row["homeaddress"];
                $fooditem = $row["fooditem"];
                $itemquantity = $row["itemquantity"];
                $itemamount = $row["itemamount"];
               $destinationaddress = $row["destinationaddress"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error1.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Home Address</label>
                        <p class="form-control-static"><?php echo $row["homeaddress"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Food Item</label>
                        <p class="form-control-static"><?php echo $row["fooditem"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Item Quantity</label>
                        <p class="form-control-static"><?php echo $row["itemquantity"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Item Amount</label>
                        <p class="form-control-static"><?php echo $row["itemamount"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>Destination Address</label>
                        <p class="form-control-static"><?php echo $row["destinationaddress"]; ?></p>
                    </div>
                    <center><p><a href="home1.php" class="btn btn-primary">Back</a></p></center>
                    <center><p><a href="homeindex.html" class="btn btn-primary">Home</a></p></center>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>