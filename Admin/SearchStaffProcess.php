<!-- Task 6 (4 marks)
- admin
- query produces correct results
- page contains similar info to screenshot
- links working -->

<?php
    session_start();
    include_once('../functions/check_admin.php');
    include_once '../functions/db_conn.php';

    //checks which link was clicked by the user
    if (isset($_SESSION['updatestaffkpi']) && !empty($_SESSION['updatestaffkpi'])) {
        $update = $_SESSION['updatestaffkpi'];
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
        <h1 class="title">Staff Information</h1>
        <br/>
        <section class="container">
            <?php 
                $msgErr = "";
                $searchName = "";
                
                $staffName = $_GET['searchName'];

                $search = ucwords($staffName); //ucwords() --> changes first letter of each word to uppercase

                $sql = "SELECT * FROM staff_table WHERE name LIKE '$search%'";

                $result = mysqli_query($conn, $sql);
                $matches = mysqli_num_rows($result);
                if ($matches == 0) {
                    echo "<p class = 'error'><strong>No matches found</strong></p></br></br>";
                }
                

            ?> 
            
            <fieldset class="container2">
                <Legend>Search Results</Legend>
                <p><?php echo $matches;?>  result(s) found</p>
                <ul>
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            if (isset($_SESSION['updatestaffKPI'])){
                                echo '<li class="nested"><a href="UpdateStaffKPI.php?staff_id='.$row['staff_id'].'">'.$row['name'].'</a></li>';
                            }else{
                                echo '<li class="nested"><a href="DisplayStaffInfo.php?staff_id='.$row['staff_id'].'">'.$row['name'].'</a></li>';

                            }
                            
                        }

                    ?>
                </ul>
            </fieldset>
        </section>
        <br/><br/>
        
    </body>

</html>