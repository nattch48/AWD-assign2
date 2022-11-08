<!-- Task 5 (3 marks)
- admin
- similar to screenshot
- input validation, message displayed
- links working -->
<?php
    session_start();
    include_once('../functions/check_user.php');
    include_once '../functions/db_conn.php'; 
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
    <h1 class="title">Search Staff Profile</h1>
    <br/>
    <section class="container">
        <hr/>
        <?php 
            $msgErr = "";
            $searchName = "";

            //checks for a GET request to see if form was submitted
            if ($_SERVER["REQUEST_METHOD"] === "GET") {

                if (isset($_GET["submit"])) {
                    if (isset($_GET["searchname"]) && !empty($_GET["searchname"])){ 
                        $searchName = test_input($_GET["searchname"]);
                        //echo $searchName; //TEST
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z-' ]*$/",$searchName)) {
                            
                            $msgErr = "Only letters and white space allowed";
                            
                        } else {
                            htmlspecialchars(header('Location:SearchStaffProcess.php?searchName='.htmlspecialchars($searchName)));
                            exit;
                        }
                        
                    } else {
                        $msgErr = "Name is required";
                    }
                }
            
            }

            //a function tht checks and sanitizes user input
            function test_input($data) {
                //removes extra space/tab/newline
                $data = trim($data);
                //removes backslashes
                $data = stripslashes($data);
                //converts special characters to string so the browser does not execute them
                $data = htmlspecialchars($data); 
                return $data;
            }

        ?> 
    
        <form method="GET" action=<?php echo htmlspecialchars("SearchStaffForm.php") ?>>

                <label for="searchname">Staff Name: </label>
                    <p><input type="text" name="searchname"/></p>
                    <!-- displays error message -->
                    <span class="error"><?php echo $msgErr;?></span>
                <br/><br/>
                <input type="submit" name="submit" value="Search Staff" >

        </form>
        <br/><br/>
        <!--End of form-->
    </section>
    <br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>