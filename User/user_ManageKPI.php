
<?php
    session_start();
    include_once('../functions/check_user.php');
    include_once('../functions/db_conn.php'); 
    $avatar_path = "";
    $staffId = "";

    if (isset($_SESSION['user_staff_id']) && !empty($_SESSION['user_staff_id'])) {
        $staffId = $_SESSION['user_staff_id'];
    }

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
        if(isset($_POST['add_kpi'])) {
            $_SESSION['staff_name'] = $row['name'];
            header("Location: user_AddKPI.php");
        }
        if (isset($_POST["remove"])) {
            $id=$_POST['id'];
            $sql="DELETE FROM staff_kpi_table WHERE id='$id'";
            mysqli_query($conn,$sql);
        }
        if (isset($_POST["approve"])) {
            $id=$_POST['id'];
            $sql="UPDATE staff_kpi_table SET `status`='Approved' WHERE id='$id'";
            mysqli_query($conn,$sql);
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
    <?php include_once '../functions/user_header.php'; ?>
    <br/>
    <h1 class="title">Manage Key Performance Indicator</h1>
    <br/>
    <section class="container">
        <hr/><br/>
        <div class="intro">
            <div class="avatar">
                <div class="avatar-img">
                    <?php if ($matches > 0) {?>
                        <p><img src="../images/<?php echo $avatar_path ?>" alt="Female Avatar"/></p>
                    <?php }else{ ?>
                        <p class="error">Image unavailable</p>
                    <?php } ?>
                </div>
                
            </div>
            <h2><?php echo $row['name'] ?></h2>
            <p><?php echo $row['staff_id'] ?></p>
            <p><?php echo $row['email'] ?></p>

        </div>
        
        <br/><br/>
        <div class="mm_row">
            <div class="staff_kpi">
                <p class="center" style="color: red;"><?php echo $row['name']."'s KPI"?></p>
                <table class="styled-table">  				
                    <tr>
                        <th>KPI List</th>	
                        <th>Approval Status</th>
                        <th>Remove</th>					  				  										  				  					
                    </tr>
                    
                    <?php  
                        $sql_kpi = "SELECT * FROM staff_kpi_table WHERE staff_id='$staffId' ORDER BY kpi_num;";
                        $staffkpi=mysqli_query($conn, $sql_kpi);
                        while ($row = mysqli_fetch_assoc($staffkpi)){ 
                            echo '<tr><td class="content_left">'.$row['kpi_num'] ."</td>";
                            //approval status column
                            if ($row['status']=="Pending" || $row['status']=="pending") {
                                echo '<td>Pending</td>';
                            } else {
                                echo "<td>Approved</td>";
                            }

                            if ($row['status']=="Pending" || $row['status']=="pending") {
                                echo '<td> <form method="POST" id="myForm" action="">
                                        <input  name="id" type="hidden" value=' .$row["id"].'>   
                                        <input type="submit" name="remove" value="Remove" >
                                    </form>
                                    </td></tr>';
                            }else{
                                echo '<td> <form method="POST" id="myForm" action="">
                                        <input  name="id" type="hidden" value=' .$row["id"].'>   
                                        <input type="submit" name="remove" value="Remove" disabled="disabled" >
                                    </form>
                                    </td></tr>';
                            }
                        }						
                    ?>
                                                                        
                </table>
                <form method="POST" id="myForm" action="" class="center">
                    <input type="submit" name="add_kpi" value="Add KPI" >
                </form>
            </div>
           
        </div>
                
    </section>
    <br/><br/>
        
    </body>
    <?php include_once "../functions/user_footer.php"?>

</html>