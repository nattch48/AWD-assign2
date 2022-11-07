<?php 
    session_start();
    if (isset($_SESSION['email'])) { //if session is set, destroy it
        session_unset();
        session_destroy();
    }
    
    include_once '../functions/db_conn.php'; 

    $errorMsg = "";
    $showError = false;

    if (isset($_POST['reset'])) {
        header("Location:login.php");
    }

    if(isset($_POST['login'])) {
        // Sanitize input data
        $login=mysqli_real_escape_string($conn, $_POST['login_name']);
        $pwd = mysqli_real_escape_string($conn, $_POST['login_pwd']);

        $sql = "SELECT * FROM account_table WHERE name='$login'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            //validates password with the ones in the DB
            if ($row['password']==$pwd) {
                session_start();
                $_SESSION['email'] = $row['email'];

                //stores staff id in a variable
                $staff_id = $row['staff_id'];

                //sql query to search staff_table for staff_id
                $sql = "SELECT * FROM staff_table WHERE staff_id='$staff_id'";
                $staff_result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($staff_result) > 0) {
                    $staff_table_row = mysqli_fetch_assoc($staff_result);
                    //to find out whether the staff is an admin or a user
                    if ($row['type']=='admin') {
                        $_SESSION['type'] = 'admin';
                        header("Location: MainMenu.php");
                    } else if ($row['type']=='user') {
                        $_SESSION['type'] = 'user';
                        header("Location: MainMenu2.php");
                    } else {
                        $errorMsg = "Invalid account type";
                    }



                }else {
                    $errorMsg = "Invalid staff id";
                }
                
            } else {
                $errorMsg = "Invalid password";
                $showError = true;
            }

        }else{
            $errorMsg = "Invalid login name";
            $showError = true;
        }
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
            <h1 class="title">KPI Assignment System</h1>
            <br/>
            <h2 class="title">Login Page</h2>
            <br/>
            <div class="split">
                <div class="login_img">
                    <img src="../images/top_image.png" alt="Login Image">
                </div>
                <div class="login_content">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <p><label for="login_name">Login Name: </label>
                        <input type="text" name="login_name"/></p>
                    <p><label for="login_pwd">Password: </label>
                        <input type="text" name="login_pwd"/></p>
                    <br/><br/>
                    <input type="submit" name="login" value="Login" >
                    <input type="submit" name="reset" value="Clear Form" >

                    </form>
                </div>
            </div>

                
            <?php
                if ($showError==true) {

                
            ?>

            <fieldset>
                <legend><strong>ERROR</strong></legend>
                <ul>
                    <li class="error"><?php echo $errorMsg ?></li>
                </ul>
            </fieldset>      

            <?php
                }
            ?>
        
        </section>
        <br/><br/>
        
    </body>

</html>