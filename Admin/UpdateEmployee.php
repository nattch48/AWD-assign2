<?php
    session_start();
    include_once('../functions/check_admin.php');
    include_once('../functions/db_conn.php'); 

    //initialising variables
    $saved = false;
    $saveMsg = "";
    $errCount = 0;
    $nameErr = $staffIdErr = $emailErr = $genderErr = $facultyErr = "";
    $name = $staff_id = $email = $gender = $faculty = "";

    if (isset($_SESSION['update_staff']) && !empty($_SESSION['update_staff'])) {
        $staff_id = $_SESSION['update_staff'];
    } else {
        echo "<script type='text/javascript'>alert('You have not selected a staff profile. Please try again.');
                window.location.href='../Admin/SearchStaffForm.php';
                </script>";
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset ($_POST["name"]) && (!empty($_POST["name"])) ){ 
            $name = ucwords(test_input($_POST["name"]));
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $errCount++;
                $nameErr = "Only letters and white space allowed";
                
            }
            
        } else {
            $nameErr = "Name is required";
            $errCount++;
        }

        if (isset ($_POST["email"]) && (!empty($_POST["email"])) ){ 
            $email = test_input($_POST["email"]);
            // check if email domain is @swinburne.edu.my
            if (!preg_match("/^.*@swinburne.edu.my*$/",$email)) {
                $errCount++;
                $emailErr = "invalid email format";
            }
        }else{
            $errCount++;
            $emailErr = "Email is required";
        }

        if (isset ($_POST["gender"]) ){ 
            $gender = $_POST["gender"];
        
        }

        if (isset ($_POST["faculty"] )) {
            $faculty = $_POST["faculty"];
        }
        
        //if all required fields are filled correctly, save to DB and echo message.
        if ($errCount === 0) {
            $acc_name = str_replace('@swinburne.edu.my', '', $email);
            $sql_staff = "UPDATE staff_table SET email='$email', `name`='$name', gender='$gender', school='$faculty'  WHERE staff_id='$staff_id'";
            $sql_acc = "UPDATE account_table SET `name`='$acc_name', email='$email'  WHERE staff_id='$staff_id'";
            
            populateDB($conn, $sql_staff, 'staff');
            populateDB($conn, $sql_acc, 'account');

            $saved = true;
            $saveMsg = "Record is saved.";

            //clear $_POST and $_SESSION variables
            $_POST = array();
            unset($_SESSION['update_name']);
            unset($_SESSION['update_gender']);
            unset($_SESSION['update_email']);
            unset($_SESSION['update_school']);
            header("Location: DisplayStaffInfo.php?staff_id=$staff_id");

        } 
   
    }

    //sanitizes user input for improved security
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
        <h1 class="title">Update Staff Profile</h1>
        <br/>
        <section class="container">
            <hr/>
            <br/>
            <!-- uses post method -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                
                <fieldset class="container2">
                    <!--Start of fieldset-->
                    <legend>Personal Information</legend>
                    <p><span class="error">* required fields</span></p>
                    <label for="name">Full name: </label>
                        <input type="text" name="name" id="name" maxlength="20" value="<?php echo isset($_SESSION['update_name']) ? $_SESSION['update_name'] : ''; ?>"/>
                        <span class="error">* <?php echo $nameErr;?></span>
                    <!--text field is disabled and uneditable-->
                    <p><label for="staffID">Staff ID: </label>
                        <input type="text" name="staffID" id="staffID" value="<?php echo isset($_SESSION['update_staff']) ? $_SESSION['update_staff'] : ''; ?>" disabled/>
                        <span class="error">* <?php echo $staffIdErr;?></span>
                    </p>
                    <p><label for="email">Email: </label>
                        <input type="text" name="email" id="email" placeholder="name@swinburne.edu.my" size="25" value="<?php echo isset($_SESSION["update_email"]) ? $_SESSION["update_email"] : ''; ?>"/>
                        <span class="error">* <?php echo $emailErr;?></span>
                    </p>
                    <p><label for="gender">Gender: </label>
                        <select name="gender" id="gender">
                            <optgroup label="--select your gender--">
                                <option value="Male">Male</option>
                                <option value="Female" <?php if (isset($_SESSION["update_gender"]) && ($_SESSION["update_gender"]=="Female")) {echo 'selected';} ?>>Female</option>
                            </optgroup>
                        </select>
                    </p>
                    <p><label for="faculty">School/Faculty: </label>
                        <select name="faculty" id="faculty" >
                            <optgroup label="--Select your School/Faculty--">
                                <option value="SFS">SFS</option>
                                <option value="FBDA" <?php if (isset($_SESSION['update_school']) && ($_SESSION['update_school']=="FBDA")) {echo 'selected';} ?>>FBDA</option>
                                <option value="FECS" <?php if (isset($_SESSION['update_school']) && ($_SESSION['update_school'] =="FECS")) {echo 'selected';} ?>>FECS</option>
                            </optgroup>
                        </select>
                    </p>

                    <input type="submit" id="submit" value="Update Staff" >

                </fieldset>
            </form>
            <!--End of form-->
            
            <!-- prints out verification that the form was successfully submitted -->
            <span class="saveRec"><strong><?php echo $saveMsg;?></strong></span>
        </section>
        <br/><br/>
        
    </body>
    <?php include_once "../functions/footer.php"?>

</html>