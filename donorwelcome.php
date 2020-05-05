<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminlogin.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
   <div class="main">
        <ul>

        <li><a href="homeindex.html" class="btn btn-warning">Home</a></li>
        <li><a href="donorreset.php" class="btn btn-warning">Reset Your Password</a></li>
        <li><a href="donorlogout.php" class="btn btn-danger">Sign Out of Your Account</a></li>
        <li><a href="home1.php" class="btn btn-warning">Make Donations</a></li>
        <li><a href="https://www.paypal-mobilemoney.com/m-pesa" class="btn btn-danger">Make Payment</a></li>
        
        </ul>
    </div>

    <div class ="title">
            <li><h1>Hello Donor, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to iDONATE.</h1></li>
            
    </div>
      
   
</body>
</html>