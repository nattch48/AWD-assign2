<!-- Task 7 (10 marks)
- admin
- staff info displayed accordingly
- update and delete button working
- links working -->

<?php
    session_start();
    include_once('../functions/check_user.php');
    include_once('../functions/db_conn.php'); 
    $avatar_path = "";
    $staffId = $_GET['staff_id'];
    $sql = "SELECT * FROM staff_table WHERE staff_id = '$staffId'";

    $result = mysqli_query($conn, $sql);
    $matches = mysqli_num_rows($result);

    $row = mysqli_fetch_assoc($result);
    
    if ($matches>0) {
        //display avatar based on gender
        if ($row['gender'] == 'Female') {
            $avatar_path = 'avatar_female.jpg';
        } else {
            $avatar_path = 'avatar_male.jpg';
        }

        //if buttons are clicked
        if(isset($_POST['update'])) {
            $_SESSION['update_staff_id'] = $staffId;
            $_SESSION['update_name'] = $row['name'];
            $_SESSION['update_gender'] =$row['gender'];
            $_SESSION['update_email'] = $row['email'];
            $_SESSION['update_school'] = $row['school'];

            header("Location: UpdateEmployee.php");
        }
        if(isset($_POST['delete'])) {
            //delete staff record from staff_table & staff_kpi_table
            $delete_staff_kpi = "DELETE FROM staff_kpi_table WHERE staff_id = '$staffId';";
            $delete_acc = "DELETE FROM account_table WHERE staff_id = '$staffId';";
            $delete_staff = "DELETE FROM staff_table WHERE staff_id = '$staffId';";

            
            execute_query($conn, $delete_staff_kpi, 'staff_kpi delete');
            execute_query($conn, $delete_acc, 'acc delete');
            execute_query($conn, $delete_staff, 'staff delete');
            
            $chk_delete_sql = "SELECT * FROM staff_table WHERE staff_id = '$staffId'";
            $chk_delete = mysqli_query($conn, $chk_delete_sql);

            if (mysqli_num_rows($chk_delete)<1) {
                $_SESSION['deleted'] = 'Record is deleted successfully.';
            }else {
                $_SESSION['deleted'] = 'Record deletion unsuccessful.';

            }
            //redirect to DeleteConfirm.php
            header("Location: DeleteConfirm.php");
            unset($_POST);
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
    <?php include_once '../functions/admin_header.php'; ?>
    <br/>
    <h1 class="title">Staff Profile</h1>
    <br/>
    <section class="container">
        <hr/><br/>
        
        <div class="avatar">
            <?php if ($matches > 0) {?>
                <img src="../images/<?php echo $avatar_path ?>" alt="Female Avatar"/>
            <?php }else{ ?>
                <p class="error">Image unavailable</p>
            <?php } ?>
        </div>
        <br/>
        <div>
            <fieldset class="container2">
                <Legend>Staff Information</Legend>
                <ul>
                    <?php 
                       if ($matches>0) {
                            //prints out employee details with bolded labels
                            echo "<strong>Name: </strong>".$row['name']."<br/>";
                            echo "<strong>Staff ID: </strong>".$row['staff_id']."<br/>";
                            echo "<strong>Email: </strong>".$row['email']."<br/>";
                            echo "<strong>Gender: </strong>".$row['gender']."<br/>";
                            echo "<strong>School: </strong>".$row['school']."<br/>";
                         }else{
                            echo "<p class = 'error'><strong>No matches found</strong></p></br></br>";

                        }
                                         
                    
                    ?>
                </ul>
                <?php if ($matches > 0) {?>
                    <form method="post">
                        <div class="buttonHolder">
                            <input type="submit" name="update"
                                    class="button" value="Update" />
                            
                            <input type="submit" name="delete"
                                    class="button" value="Delete" />
                        </div>
                    </form>
                <?php } ?>
            </fieldset>
        </div>
    </section>
    <br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>