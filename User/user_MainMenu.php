<?php
    session_start();
    include_once('../functions/db_conn.php');
    include_once('../functions/check_user.php');
    include_once('../functions/user_header.php');

    if (isset($_SESSION['user_staff_id']) && !empty($_SESSION['user_staff_id'])) {
        $staff_id = $_SESSION['user_staff_id'];
    }

    //get name of user from db based on staff_id stored in session variable
    $sql = "SELECT * FROM staff_table WHERE staff_id='$staff_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

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
            <h1 class="title">Welcome <?php echo $row['name'] ?></h1>
            <br/><br/>
            <div class="mm_row">
                <div class="mm_column">
                    <img src="../images/red_main.png" alt="Staff Module">
                    <ul>
                        <li><a href="#">Manage KPI</a></li>
                        <li><a href="#">Update Profile</a></li>
                    </ul>
                </div>
                

            </div>
            <br/><br/>
            
      
        </section>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>