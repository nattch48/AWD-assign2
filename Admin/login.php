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
        <?php include_once '../functions/db_conn.php'; ?>
        <section class="container">
            <br/>
            <h1 class="title">KPI Assignment System</h1>
            <br/>
            <h2 class="title">Login Page</h2>
            <br/>
            <div class="split">
                <div class="login_img">
                    <img src="../images/top_image.png" alt="Industrial Style Living Room">
                </div>
                <div class="login_content">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <p><label for="login_name">Login Name: </label>
                        <input type="text" name="login_name"/></p>
                        <!-- displays error message -->
                        <!-- <span class="error"><?php echo $msgErr;?></span> -->
                    <p><label for="login_pwd">Password: </label>
                        <input type="text" name="login_pwd"/></p>
                    <br/><br/>
                    <input type="submit" name="login" value="Login" >
                    <input type="reset" name="clear" value="Clear Form" >

                    </form>
                </div>
            </div>
        
        </section>
        <br/><br/>
        
    </body>
    <footer class="footer">
        <p><a href="login.php">Login</a> | 
        <a href="../about.php">About This Assignment</a>
        <br/>
    </footer>

</html>