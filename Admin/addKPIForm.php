<?php
    session_start();
    include_once('../functions/check_admin.php');
    include_once('../functions/admin_header.php');
    include_once('../functions/db_conn.php');
    $num=$desc ="";
    $numErr = $descErr ="";
    $result = "";

    if(isset($_POST["submit"]) ){
    if ($_POST["submit"]=="Add KPI") {
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
            $result=addKPI($conn,$num,$desc);
        }
    }

    }

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }

    function addKPI($conn, $num,$desc){
    $result="";

    // sql statement that ensures that there is no existing KPI number before inserting into the table
    $sql = "INSERT INTO kpi_table (kpi_num, description) 
            SELECT * FROM (SELECT '$num', '$desc') AS tmp
            WHERE NOT EXISTS(  
                SELECT kpi_num FROM kpi_table WHERE kpi_num = '$num') LIMIT 1";  
    
    mysqli_query($conn, $sql);  
    if ( mysqli_affected_rows($conn)>0)
        $result="Records inserted successfully.";
    else
        $result="There is an existing KPI number. Please use a different number";
    return $result;
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
    <pre>
<?php var_dump($_POST); ?>
</pre>
        <section class="container">
            <br/>
            <h1 class="title">Add KPI</h1>
            <br/><br/>
            <div class="center-fieldset">
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
                                    <input type="text" id="numbering" name="numbering" maxlength="4" style="height:25px;" size="2" value="<?php echo isset($_POST["numbering"]) ? $_POST["numbering"] : ''; ?>"> <span class="error">* <?php echo $numErr;?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="description">Description:</label>
                                </td>
                                <td>
                                    <textarea id="description" name="description" rows="3" cols="70"><?php echo isset($_POST["description"]) ? $_POST["description"] : ''; ?></textarea > <span class="error">* <?php echo $descErr;?></span>
                                </td>
                            </tr>

                        </table>
                        <input type="submit" value="Add KPI" class="button" name="submit" >

                    </fieldset>
                </form>
            </div>

            <p style="text-align:center; font-weight: bold;"> <?php echo $result;?> </p>
      
        </section>
        <br/><br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>