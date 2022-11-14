<?php
//set name and staff as session variables in updateStaffKPI.php

    session_start();
    include_once('../functions/check_user.php');
    include_once('../functions/user_header.php');
    include_once('../functions/db_conn.php');

    if (isset($_SESSION['user_staff_id']) && !empty($_SESSION['user_staff_id'])) {        
        $staff_id=$_SESSION['user_staff_id'];
    }

    if(isset($_POST["submit"]) ){
        $msg = "";
        if (isset($_POST['pwd']) && !empty($_POST['pwd']) && isset($_POST['confirm_pwd'])  && !empty($_POST['confirm_pwd'])) {
            $pwd=$_POST['pwd'];
            $confirm_pwd=$_POST['confirm_pwd'];

            if (strcmp($pwd, $confirm_pwd) == 0) { //strcmp returns 0 if the strings are identical 
                $sql = "SELECT * FROM account_table WHERE staff_id='$staff_id'";
                $result = mysqli_query($conn, $sql);
    
                if (mysqli_num_rows($result)>0) {
                    $msg=changePwd($staff_id, $pwd, $conn, $msg);
                }else{
                    echo "<p class='error'>Password change failed! An unexpected error has occured.</p>";
                }
            }else{
                $msg = "<span class='error'>Both passwords do not match. Please try again.</span>";
            }
        }else{
            $msg = "<span class='error'>Incomplete input. Please fill in all the fields.</span>";
        }
	}

    function changePwd($staff_id, $pwd, $conn, $msg){
        $hash = hash('sha256', $pwd); //hash pwd with SHA256 algorithm
        $sql = "UPDATE account_table SET password='$hash' WHERE staff_id='$staff_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_query($conn, $sql)) {
            $msg = "<h3 class>Password has been changed. Please log in with your new password.</h3>";
            //log user out
            session_unset();
            session_destroy();
        }else{
            $msg = "ERROR: Could not execute SQL." . mysqli_error($conn);
        }
        return $msg;

    }

    
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="COS30020 - Assignment 2" />
        <meta name="keywords" content="HTML, CSS, PHP" />
        <meta name="author" content="Natasia Ting" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" type="text/css"
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" />
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Slabo+27px&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css" />
        <title>KPI Assignment System</title>

    </head>


    <body>
        <section class="container">
            <br/>
            <h1 class="title">Reset Password</h1>
            <br/><br/>
            <fieldset>
                <legend>Personal Information</legend>
                <table class="table-center">
                    <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> class="center">
                        <tr>
                            <td>
                                <label for="name">New Password: </label>
                            </td>
                            <td>
                                <input type="text" name="pwd" id="pwd" value="<?php echo isset($_POST["pwd"]) ? $_POST["pwd"] : ''; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td class="pwd-text">
                                <span><em>Minimum 6 characters</em></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                               <p><label for="name">Confirm Password: </label>   
                            </td>
                            <td>
                                <input type="text" name="confirm_pwd" id="confirm_pwd" value="<?php echo isset($_POST["confirm_pwd"]) ? $_POST["confirm_pwd"] : ''; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"  class="padding">
                                <input type="submit" name="submit" value="Reset Password" />

                            </td>
                        </tr>
                        

                    </form>
                </table>

                <br/>
            </fieldset>
            <div class="center">
            <?php echo $msg; ?>
            </div>
        </section>
        <br/><br/><br/>
        
    </body>
    <?php include_once "../functions/user_footer.php"?>

</html>