<?php
//create db called 'staff_db' with 4 tables (staff_table, kpi_table, staff_kpi_table, account_table)

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "staff_db";

    // Creating connection
    $conn = mysqli_connect($servername, $username, $password);

    // Checking connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $db_selected = mysqli_select_db($conn, $db);

    if (!$db_selected) {
        //staff_db doesnt exist or cannot be seen
        $sql = "CREATE DATABASE staff_db";

        execute_query($conn, $sql, $db);
    }
    
    $conn = mysqli_connect($servername, $username, $password, $db);

    $staff_table = "CREATE TABLE IF NOT EXISTS staff_table (
                    id INT(4) NOT NULL AUTO_INCREMENT, 
                    staff_id VARCHAR(6) NOT NULL UNIQUE,
                    email VARCHAR(50) NOT NULL,
                    `name` VARCHAR(50) NOT NULL,
                    gender VARCHAR(6) NOT NULL,
                    school VARCHAR(5) NOT NULL,
                    PRIMARY KEY (id))";

    $kpi_table = "CREATE TABLE IF NOT EXISTS kpi_table (
        id INT(4) NOT NULL AUTO_INCREMENT, 
        kpi_num INT NOT NULL UNIQUE,
        `description` VARCHAR(150) NOT NULL,
        PRIMARY KEY (id)
        )";
    

    $staff_kpi_table = "CREATE TABLE IF NOT EXISTS staff_kpi_table (
        id INT(4) NOT NULL AUTO_INCREMENT, 
        staff_id VARCHAR(6) NOT NULL,
        kpi_num INT(3) NOT NULL,
        `status` VARCHAR(12) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (staff_id) REFERENCES staff_table(staff_id),
        FOREIGN KEY (kpi_num) REFERENCES kpi_table(kpi_num))";
    


    //store login credentials
    $account_table = "CREATE TABLE IF NOT EXISTS account_table (
        id INT NOT NULL AUTO_INCREMENT, 
        staff_id VARCHAR(6) NOT NULL,
        `name` VARCHAR(50) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `type` ENUM('admin','user'),
        email VARCHAR(50) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (staff_id) REFERENCES staff_table (staff_id)
        )";



        

    execute_query($conn, $staff_table, "staff_table");
    execute_query($conn, $kpi_table, "kpi_table");
    execute_query($conn, $staff_kpi_table, "staff_kpi_table");
    execute_query($conn, $account_table, "account_table");

    $sql_chkadmin = "SELECT * FROM staff_table WHERE staff_id = 'SS001'";

    $result = mysqli_query($conn, $sql_chkadmin);
        //populate db if default admin user not found
    if (mysqli_num_rows($result) < 1) { 
        $populate_staff_tbl = "INSERT INTO staff_table (staff_id, email, `name`, gender, school) VALUES ('SS001', 'admin@swinburne.edu.my', 'admin', 'Male', 'SFS'), ('SS100', 'jennifer@swinburne.edu.my', 'Jennifer Lau', 'Female', 'SFS')";
        $populate_acc_tbl = "INSERT INTO account_table (staff_id,`name`, `password`, `type`, email) VALUES ('SS001', 'admin', 'admin', 'admin', 'admin@swinburne.edu.my'), ('SS100', 'jennifer', 'password123', 'user', 'jennifer@swinburne.edu.my')";
    
        populateDB($conn, $populate_staff_tbl, 'staff');
        populateDB($conn, $populate_acc_tbl, 'account');
    }
        


    //executes sql query to create database/tables
    function execute_query($conn, $sql_query, $name) {
        if (!mysqli_query($conn, $sql_query)) {
            echo "Error creating $name: " . mysqli_error($conn);
        }
    };


    function populateDB($conn, $sql_query, $name) {
        if (!mysqli_query($conn, $sql_query)) {
            echo " $name Error: " . mysqli_error($conn);
        }
    }

?>

