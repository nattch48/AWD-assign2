<!-- user must be loggeed in as admin to access main menu -->
<!-- page is displayed as shown in screenshot -->
<?php
    session_start();
    
    include_once('../functions/check_user.php');
    include_once('../functions/admin_header.php');
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
            <br/><br/>
            <div class="mm_row">
                <div class="mm_column">
                    <img src="../images/red.png" alt="Staff Module">
                    <ul>
                        <li><a href="AddStaffForm.php">Add Staff Profile</a></li>
                        <li><a href="SearchStaffForm.php">Manage Staff Profile</a></li>
                        <li><a href="#">Update Staff Profile</a></li>
                    </ul>
                </div>
                <div class="mm_column">
                    <img src="../images/kpi_blue.png" alt="KPI Module">
                    <ul>
                        <li><a href="#">Add KPI</a></li>
                        <li><a href="#">Manage KPI</a></li>
                    </ul>
                </div>

            </div>
            <br/><br/>
            <div class="mm_row">
                <div class="mm_column">
                    <img src="../images/report_green.png" alt="Reporting Module">
                    <ul>
                        <li><a href="#">KPI Overview</a></li>

                    </ul>
                </div>
                <div class="mm_column">
                    <img src="../images/setting_orange.png" alt="Settings">
                    <ul>
                        <li><a href="#">Availability</a></li>
                    </ul>
                </div>

            </div>
      
        </section>
        <br/><br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>