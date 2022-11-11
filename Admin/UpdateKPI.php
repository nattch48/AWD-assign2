<?php
    session_start();
    include_once('../functions/check_admin.php');
    include_once('../functions/admin_header.php');
    include_once('../functions/db_conn.php');

    $num=$desc ="";
    $numErr = $descErr ="";
    $result = "";

    if (isset($_GET['id'])){
        $id=$_GET['id'];
        $sql = "SELECT * FROM kpi_table WHERE id=$id";
        if (mysqli_query($conn, $sql)){
            $kpi_result=mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($kpi_result);  				
        }; // retrieve KPI from the table
        $num=$row['kpi_num'];
        $desc=$row['description'];
    }

    if(isset($_POST["submit"]) ){
    if ($_POST["submit"]=="Save Update") {
        if (empty($_POST["numbering"])){
            $numErr = "This field is required";
        }else {
            $num = test_input($_POST["numbering"]);
            if (!is_numeric($num) ) {
                $numErr = "Invalid input. Please enter a number.";
            }
        }

        if (empty($_POST["description"])){
            $descErr = "This field is required";
        }else {
            $desc = test_input($_POST["description"]);    
        }

        if (($numErr =="") && ($descErr =="")) {
            $id=$_POST['id'];
            $result=editKPI($conn,$num,$desc,$id);
            header("Location:manageKPIForm.php");
        }
    }

    }

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }

    function editKPI($conn, $num,$desc, $id){
        $result="";

        // sql statement that ensures that there is no existing KPI number before inserting into the table
        $sql = "UPDATE kpi_table SET kpi_num='$num', description='$desc' WHERE id='$id'";  
        
        mysqli_query($conn, $sql);  
        if ( mysqli_affected_rows($conn)>0) {
            $result="Records updated successfully.";
            
            return $result;
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
            <h1 class="title">Edit KPI</h1>
            <br/><br/>
            <form action="<?php echo $_SERVER["PHP_SELF"];?>"  method="post" >
                <fieldset  >
                    <legend><strong>KPI Details </strong></legend>

                    <table>
                        <tr>
                            <td colspan="2"><span class="error">* required field</span></td>
                        </tr>
                        <tr>
                            <td>
                                <label for="numbering">KPI No.:</label>
                            </td>
                            <td>
                                <input type="text" id="numbering" name="numbering" maxlength="4" style="height:25px;" size="2" value=<?php echo $num;?>> 
                                <span class="error">* <?php echo $numErr;?></span>
                                </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="description">Description:</label>
                            </td>
                            <td>
                                <textarea id="description" name="description" rows="3" cols="70" ><?php echo $desc;?></textarea> <span class="error">* <?php echo $descErr;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" id="id" name="id" value=<?php echo $id; ?>/>
                                <input type="submit" value="Save Update" class="button" name="submit" >
                            </td>
                        </tr>

                    </table>
                </fieldset>
            </form>

            <p style="text-align:center; font-weight: bold;"> <?php echo $result;?> </p>
      
        </section>
        <br/><br/>
    </body>

</html>