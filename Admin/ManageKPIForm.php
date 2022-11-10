<?php
    session_start();
    include_once('../functions/check_admin.php');
    include_once('../functions/admin_header.php');
    include_once('../functions/db_conn.php');
    $result = "";

    if(isset($_POST["submit"]) ){
		if ($_POST["submit"]=="Delete KPI") {
				$id=$_POST['id'];
				$sql="DELETE FROM kpi_table WHERE id='$id'";
				mysqli_query($conn,$sql);
		}

		if ($_POST["submit"]=="Edit KPI") {
		$id=$_POST['id'];
		header("Location: UpdateKPI.php?id=$id");
		}

	}

    $sql="select * from kpi_table ORDER BY kpi_num";
    $result=mysqli_query($conn,$sql);
    
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
            <h1 class="title">Manage Key Performance Indicator</h1>
            <br/><br/>
            <div class="item">
                <div class="content">
                    <table>  				
                    <tr>
                        <th>KPI List</th>	
                        <th>Click to edit KPI</th>
                        <th>Click to delete KPI</th>					  				  										  				  					
                    </tr>
                    
                    <?php  
                            while ($row = mysqli_fetch_assoc($result)){ 
                                echo '<tr><td class="content_left">'.$row['kpi_num'] ." - ".$row['description'] ."</td>";
                                echo '<td> <form method="POST" id="myForm" action="">
                                        <input  name="id" type="hidden" value=' .$row["id"].'>   
                                        <input type="submit" name="submit" value="Edit KPI" >
                                    </form>
                                    </td>';
                                echo '<td> <form method="POST" id="myForm" action="">
                                        <input  name="id" type="hidden" value=' .$row["id"].'>   
                                        <input type="submit" name="submit" value="Delete KPI" >
                                    </form>
                                    </td></tr>';
                            }						
                        ?>
                                                                        
                    </table>
                    

                </div>
            </div>
        </section>
        <br/><br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>