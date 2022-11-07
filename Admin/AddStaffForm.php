<!-- Task 4 (10 marks)
- admin
- screenshot
- input validated
- errors displayed
- records added to staff_table and account_table
- links -->
<?php
    session_start();
    echo $_SESSION['email'];
    include_once('../functions/check_user.php');
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
    <h1 class="title">Add Staff Profile</h1>
    <br/>
    <section class="container">
        <hr/>
        <br/>
        <?php 
            //initialising variables
            $saved = false;
            $saveMsg = "";
            $errCount = 0;
            $newEntry = array();
            $nameErr = $staffIdErr = $emailErr = $genderErr = $facultyErr = "";
            $name = $staffId = $email = $gender = $faculty = "";

            //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~FORM VALIDATION STARTS HERE!!!!!!!!!!!!~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            //checks for a POST request to see if form was submitted --> https://www.geeksforgeeks.org/how-to-create-a-php-form-that-submit-to-self/
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
                if (isset ($_POST["name"]) && (!empty($_POST["name"])) ){ 
                    $name = ucwords(test_input($_POST["name"]));
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                        $errCount++;
                        $nameErr = "Only letters and white space allowed";
                        
                    } else {
                        $newEntry['Name'] = $name;
                    }
                    
                } else {
                    $nameErr = "Name is required";
                    $errCount++;
                }

                if (isset ($_POST["staffID"]) && (!empty($_POST["staffID"])) ){ 
                    $staffId = test_input(strtoupper($_POST["staffID"]));
                    // check if Staff ID starts with SS followed by the number
                    if (!preg_match("/^SS[0-9]{3,4}$/",$staffId)) {
                        $errCount++;
                        $staffIdErr = "Staff ID should start with SS followed by the number";
                    } else {
                        $staffId = mysqli_real_escape_string($conn, $staffId);
                        //checks if staffID is taken
                        $sql = "SELECT * FROM staff_table WHERE staff_id='$staffId'";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $staffIdErr = "Found matches. There is an existing ID with ID: $staffId";
                            $errCount++;
                        }else{
                            echo "No matches found.";
                            $newEntry['staff ID'] = $staffId;
                        }
                        
                    }
                    
                    
                } else {
                    $errCount++;
                    $staffIdErr = "Staff ID is required";
                    
                }

                if (isset ($_POST["email"]) && (!empty($_POST["email"])) ){ 
                    $email = test_input($_POST["email"]);
                    // check if email domain is @swinburne.edu.my
                    if (!preg_match("/^.*@swinburne.edu.my*$/",$email)) {
                        $errCount++;
                        $emailErr = "invalid email format";
                    } else {
                        $newEntry['Email'] = $email;
                    }
                
                }else{
                    $errCount++;
                    $emailErr = "Email is required";
                }

                if (isset ($_POST["gender"]) ){ 
                    $gender = $_POST["gender"];
                    $newEntry['Gender'] = $gender;
                
                }

                if (isset ($_POST["faculty"] )) {
                    $faculty = $_POST["faculty"];
                    $newEntry['School'] = $faculty;
                }

                
                //if all required fields are filled correctly, save to DB and echo message.
                if ($errCount === 0) {

                    $sql = "INSERT INTO staff_table () VALUES ();
                            INSERT INTO account_table () VALUES ()";

                    $saved = true;
                    $saveMsg = "Record is saved.";
                    //clear array
                    $_POST = array();
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

        <!-- uses post method -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            
            <fieldset class="container2">
                <!--Start of fieldset-->
                <legend>Personal Information</legend>
                <p><span class="error">* required fields</span></p>
                <label for="name">Full name: </label>
                    <input type="text" name="name" id="name" maxlength="20" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>"/>
                    <span class="error">* <?php echo $nameErr;?></span>
                
                <p><label for="staffID">Staff ID: </label>
                    <input type="text" name="staffID" id="staffID" value="<?php echo isset($_POST["staffID"]) ? $_POST["staffID"] : ''; ?>"/>
                    <span class="error">* <?php echo $staffIdErr;?></span>
                </p>
                <p><label for="email">Email: </label>
                    <input type="text" name="email" id="email" placeholder="name@swinburne.edu.my" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>"/>
                    <span class="error">* <?php echo $emailErr;?></span>
                </p>
                <p><label for="gender">Gender: </label>
                    <select name="gender" id="gender">
                        <optgroup label="--select your gender--">
                            <option value="Male">Male</option>
                            <option value="Female" <?php if (isset($_POST["gender"]) && ($_POST["gender"]=="Female")) {echo 'selected';} ?>>Female</option>
                        </optgroup>
                    </select>
                </p>
                <p><label for="faculty">School/Faculty: </label>
                    <select name="faculty" id="faculty" >
                        <optgroup label="--Select your School/Faculty--">
                            <option value="SFS">SFS</option>
                            <option value="FBDA" <?php if (isset($_POST["faculty"]) && ($_POST["faculty"]=="FBDA")) {echo 'selected';} ?>>FBDA</option>
                            <option value="FECS" <?php if (isset($_POST["faculty"]) && ($_POST["faculty"]=="FECS")) {echo 'selected';} ?>>FECS</option>
                        </optgroup>
                    </select>
                </p>

                <input type="submit" id="submit" value="Add Staff" >

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