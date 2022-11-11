<!-- 5 marks
- must be logged in as admin
- info displayed according to screenshots
- links are working and uses relative addressing-->

<?php
    $msg = '';
    session_start();
    include_once('../functions/check_admin.php');
    include_once('../functions/db_conn.php'); 

    $sql = "SELECT k.kpi_num, k.description, GROUP_CONCAT(s.name) AS staff_list, COUNT(sk.staff_id) as staff_count 
            FROM kpi_table k LEFT JOIN staff_kpi_table sk ON k.kpi_num = sk.kpi_num 
            LEFT JOIN staff_table s ON sk.staff_id = s.staff_id GROUP BY k.kpi_num; ";
    $result = mysqli_query($conn, $sql);
    
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
        <h1 class="title">KPI Overview</h1>
        <br/>
        <section class="container">
            <hr/><br/>
            <div class="item">
                <div class="content">
                    <table class="styled-table">  				
                    <tr>
                        <th>KPI List</th>	
                        <th>List of Staff</th>
                        <th>Total Staff</th>					  				  										  				  					
                    </tr>
                    
                    <?php  
                            while ($row = mysqli_fetch_assoc($result)){ 
                                echo '<tr><td class="content_left">'.$row['kpi_num'] ." - ".$row['description'] ."</td>";
                                echo '<td>' .$row['staff_list'].'
                                    </td>';
                                echo '<td class="center">'.$row['staff_count'].'
                                    </td></tr>';
                            }						
                        ?>
                                                                        
                    </table>
                </div>
            </div>
        </section>
        <br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>