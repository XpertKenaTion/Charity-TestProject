<?php
// Include config file
require_once "config2.php";
 
// Define variables and initialize with empty values
$name = $email =$homeaddress = $fooditem = $itemquantity = $itemamount = $destinationaddress = "";
$name_err = $email_err = $homeaddress_err = $fooditem_err = $itemquantity_err = $itemamount_err = $destinationaddress_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

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
    } else{
        $itemamount = $input_itemamount;
    }

   

    // Validate  destinationaddress
    $input_destinationaddress = trim($_POST["destinationaddress"]);
    if(empty($input_destinationaddress)){
        $destinationaddress_err = "Please enter a destination address.";     
    } else{
        $destinationaddress = $input_destinationaddress;
    }


    // Check input errors before inserting in database
     if(empty($name_err) && empty($email_err) && empty($homeaddress_err) && empty($fooditem_err) && empty($itemquantity_err) && empty($itemamount_err)&& empty($destinationaddress_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO donor (name,email, homeaddress,fooditem,itemquantity,itemamount, destinationaddress) VALUES (?, ?, ?, ?, ?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_email, $param_homeaddress, $param_fooditem, $param_itemquantity,$param_itemamount,$param_destinationaddress,);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_homeaddress = $homeaddress;
            $param_fooditem = $fooditem;
            $param_itemquantity=$itemquantity;
            $param_itemamount=$itemamount;
            $param_destinationaddress = $destinationaddress;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: home1.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
         mysqli_close($stmt);
    }
    
      // Close connection
        mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2> Donor Donation Record</h2>
                    </div>
                   
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        
                         <div class="form-group <?php echo (!empty($destinationaddress_err)) ? 'has-error' : ''; ?>">
                            <label>Destination address</label>
                            <input type="text" name="destinationaddress" class="form-control" value="<?php echo $destinationaddress; ?>">
                            <span class="help-block"><?php echo $destinationaddress_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <center><a href="home1.php" class="btn btn-default">Cancel</a></center>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>