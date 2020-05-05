<?php
// Include config file
require_once "config2.php";
 
// Define variables and initialize with empty values
$name = $email =$homeaddress = $fooditem = $itemquantity = $itemamount = $destinationaddress = "";
$name_err = $email_err = $homeaddress_err = $fooditem_err = $itemquantity_err = $itemamount_err = $destinationaddress_err =  "";
 
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
   // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter a email.";     
    } else{
        $email = $input_email;
    }

      // Validate homeaddress
    $input_homeaddress = trim($_POST["homeaddress"]);
    if(empty($input_homeaddress)){
        $homeaddress_err = "Please enter a homeaddress.";     
    } else{
        $homeaddress = $input_homeaddress;
    }

    
    
   // Validatefooditem
    $input_fooditem= trim($_POST["fooditem"]);
    if(empty($input_fooditem)){
        $fooditem_err = "Please enter a fooditem.";     
    } else{
        $fooditem = $input_fooditem;
    }
     // Validate  itemquantity
    $input_itemquantity= trim($_POST["itemquantity"]);
    if(empty($input_itemquantity)){
        $itemquantity_err = "Please enter a itemquantity.";     
    } else{
        $itemquantity = $input_itemquantity;
    }


    // Validate itemamount
    $input_itemamount = trim($_POST["itemamount"]);
    if(empty($input_itemamount)){
        $itemamount_err = "Please enter the itemamount.";     
    } elseif(!ctype_digit($input_itemamount)){
        $itemamount_err = "Please enter a positive integer value.";
    } else{
        $itemamount = $input_itemamount;
    }
     
    // Validate destinationaddress
    $input_destinationaddress = trim($_POST["destinationaddress"]);
    if(empty($input_destinationaddress)){
        $destinationaddress_err = "Please enter a destination address.";     
    } else{
        $destinationaddress = $input_destinationaddress;
    }

    // Check input errors before inserting in database
   if(empty($name_err) && empty($email_err) && empty($homeaddress_err) && empty($fooditem_err) && empty($itemquantity_err) && empty($itemamount_err)&& empty($destinationaddress_err)){
        // Prepare an update statement
        $sql = "UPDATE donor SET name=?, email=?,homeaddress=?,fooditem=?,itemquantity=?, itemamount=?,destinationaddress=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "sssssssi", $param_name,$param_email,$param_homeaddress, $param_fooditem,$param_itemquantity, $param_itemamount, $param_destinationaddress,$param_id);
            
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_homeaddress = $homeaddress;
            $param_fooditem= $fooditem;
            $param_itemquantity= $itemquantity;
            $param_itemamount = $itemamount;
            $param_destinationaddress= $destinationaddress;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: home1.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM donor WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
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
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error1.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update  Record</h2>
                    </div>
                    
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Home Address</label>
                            <textarea name="homeaddress" class="form-control"><?php echo $homeaddress; ?></textarea>
                            <span class="help-block"><?php echo $homeaddress_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($item_err)) ? 'has-error' : ''; ?>">
                            <label>Food Item</label>
                            <input type="text" name="fooditem" class="form-control" value="<?php echo $fooditem; ?>">
                            <span class="help-block"><?php echo $fooditem_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($item_err)) ? 'has-error' : ''; ?>">
                            <label>Item Quantity</label>
                            <input type="text" name="itemquantity" class="form-control" value="<?php echo $itemquantity; ?>">
                            <span class="help-block"><?php echo $itemquantity_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($item_err)) ? 'has-error' : ''; ?>">
                            <label>Item Amount</label>
                            <input type="text" name="itemamount" class="form-control" value="<?php echo $itemamount; ?>">
                            <span class="help-block"><?php echo $itemamount_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($amount_err)) ? 'has-error' : ''; ?>">
                            <label>Destination Address</label>
                            <input type="text" name="destinationaddress" class="form-control" value="<?php echo $destinationaddress; ?>">
                            <span class="help-block"><?php echo $destinationaddress_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home1.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>