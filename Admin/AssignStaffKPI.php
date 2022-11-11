<?php
//set name and staff as session variables in updateStaffKPI.php

    session_start();
    include_once('../functions/check_admin.php');
    include_once('../functions/admin_header.php');
    include_once('../functions/db_conn.php');
    $result = "";
    
    if (isset($_SESSION['update_staff_KPI']) && !empty($_SESSION['update_staff_KPI'])) {        
        $staff_id=$_SESSION['update_staff_KPI'];
    }
    if (isset($_SESSION['staff_name']) && !empty($_SESSION['staff_name'])) {
        $staff_name=$_SESSION['staff_name'];
    }

    $assignedKPI = array();
    //get array of assigned KPI
    $sql_assignedkpi= "SELECT * FROM staff_kpi_table WHERE staff_id='$staff_id';";

    $result = mysqli_query($conn, $sql_assignedkpi);
    
    while ($row = mysqli_fetch_assoc($result)){
        array_push($assignedKPI, $row['kpi_num']);
    }
    if (count($assignedKPI)>0) {
        //forms a string containing all assigned or pending KPIs
        $assignedKPI = implode(',', $assignedKPI);
        $sql_kpi_cat = "SELECT * FROM kpi_table WHERE kpi_num NOT IN ($assignedKPI) ORDER BY kpi_num;";
    }else{
        $sql_kpi_cat = "SELECT * FROM kpi_table ORDER BY kpi_num;";
    }
    


    if(isset($_POST["submit"]) ){
		$kpi_num=$_POST['assignKPI'];
        //checks if there is duplicate entry
        $sql = "SELECT * FROM staff_kpi_table WHERE staff_id='$staff_id' AND kpi_num='$kpi_num'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "Found matches. There is an existing field with staff ID: $staff_id and kpi number: $kpi_num";
            
        }else {
            $sql="INSERT INTO staff_kpi_table(staff_id, kpi_num, `status`) VALUES ('$staff_id', $kpi_num, 'Pending');";
            mysqli_query($conn,$sql);
            unset($_POST['assignKPI']);
            header("Location: UpdateStaffKPI.php");
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
        <section class="container">
            <br/>
            <h1 class="title">Assign KPI</h1>
            <br/><br/>
            <fieldset>
                <legend><?php echo $staff_name ?></legend>
                <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> class="center">

                <label for="searchname">KPI: </label>
                    <select name="assignKPI" id="assignKPI" required>
                        <option value="" disabled selected hidden>Choose KPI</option>
                        <optgroup label="--select KPI--">
                            <?php
                                $categories = mysqli_query($conn, $sql_kpi_cat);
                                while ($category=mysqli_fetch_assoc($categories)) {
                            ?>
                            <option value="<?php echo $category['kpi_num']?>"><?php echo $category['kpi_num'] ." - ".$category['description']?></option>
                            <?php
                                }
                            ?>
                        </optgroup>
                    </select>
                <br/><br/>
                <input type="submit" name="submit" value="Assign KPI" />

        </form>
            </fieldset>
        </section>
        <br/><br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>