<?php
    $msg = '';
    session_start();
    include_once('../functions/check_user.php');
    include_once('../functions/db_conn.php'); 

    if (isset($_SESSION['deleted'])) {
        $msg = $_SESSION['deleted'];
    }else {
        staff_delete_error('You have not selected a staff to delete.');
        
    }

    //if buttons are clicked
    if(isset($_POST['deleteAnother'])) {
        header("Location: SearchStaffForm.php");
    }
    if(isset($_POST['home'])) {
        header("Location: MainMenu.php");
    }
    function staff_delete_error($msg) {
        echo "<script type='text/javascript'>alert('$msg');
        window.location.href='../Admin/SearchStaffForm.php';
        </script>";
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
        <?php include_once '../functions/admin_header.php'; ?>
        <br/>
        <h1 class="title">Staff Profile</h1>
        <br/>
        <section class="container">
            <hr/><br/>
            <div class="center">
                <p class="error"><?php echo $msg; ?></p>
            </div>
            <br/>
            <form method="post">
                <div class="buttonHolder">
                    <input type="submit" name="deleteAnother"
                            class="button" value="Delete Another Profile" />
                    
                    <input type="submit" name="home"
                            class="button" value="Home" />
                </div>
            </form>
        </section>
        <br/><br/>
        <?php
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
        unset($_SESSION['deleted']);
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
        ?>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>