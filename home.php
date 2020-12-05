

<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fname = $lname = $contact = "";
$fname_err = $lname_err = $contact_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate fname$fname
    if(empty(trim($_POST["fname$fname"]))){
        $fname_err = "Please enter a fname$fname.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM membership WHERE fname$fname = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_fname);
            
            // Set parameters
            $param_fname = trim($_POST["fname$param_fname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $fname_err = "This fname$fname is already taken.";
                } else{
                    $fname = trim($_POST["fname$fname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
   
    
    
    // Check input errors before inserting in database
    if(empty($fname_err) && empty($lname_err) && empty($contact_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO membership (fname, lname, contact) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_fname, $param_lname, $param_contact);
            
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_contact = $contact;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: logout.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body style="background-color: silver">
<header>
        
       <h2>&nbsp;&nbsp;&nbsp;&nbsp;WELCOME USER ,</h2>
       
        
    </header>
    <div class="wrapper" style="display:block ;background-color:rgba(0, 081, 078, 0.263); width:auto; color:white ; position:absolute ; top: 20%; left:35%; font-size:15px" >
        <h2>MEMBERSHIP FORM</h2><br>
        <p>Please fill this form to validate membership</p><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                <label>FIRST NAME</label>
                <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>">
                <span class="help-block"><?php echo $fname_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                <label>LAST NAME</label>
                <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>">
                <span class="help-block"><?php echo $lname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">
                <label>CONTACT</label>
                <input type="integer" name="contact$contact" class="form-control" value="<?php echo $contact; ?>">
                <span class="help-block"><?php echo $contact_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
          
        </form>
        <a href="logout.php">LOGOUT</a>
    </div>    
</body>
</html>



