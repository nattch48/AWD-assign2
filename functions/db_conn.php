<?php
//create db called 'staff_db' with 4 tables (staff_table, kpi_table, staff_kpi_table, account_table)
//CREATE TABLE IF NOT EXISTS

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
                    staff_id VARCHAR(6) NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    name VARCHAR(50) NOT NULL,
                    gender VARCHAR(6) NOT NULL,
                    school VARCHAR(5) NOT NULL,
                    PRIMARY KEY (id))";

    $kpi_table = "CREATE TABLE IF NOT EXISTS kpi_table (
        id INT(4) NOT NULL AUTO_INCREMENT, 
        kpi_num INT NOT NULL,
        description VARCHAR(150) NOT NULL,
        PRIMARY KEY (id))";
    

    $staff_kpi_table = "CREATE TABLE IF NOT EXISTS staff_kpi_table (
        id INT(4) NOT NULL AUTO_INCREMENT, 
        staff_id VARCHAR(6) NOT NULL,
        kpi_num INT(3) NOT NULL,
        status VARCHAR(12) NOT NULL,
        PRIMARY KEY (id))";

    //store login credentials
    $account_table = "CREATE TABLE IF NOT EXISTS account_table (
        id INT NOT NULL AUTO_INCREMENT, 
        staff_id VARCHAR(6) NOT NULL,
        name VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        type ENUM('admin','user'),
        email VARCHAR(50) NOT NULL,
        PRIMARY KEY (id))";



    execute_query($conn, $staff_table, "staff_table");
    execute_query($conn, $kpi_table, "kpi_table");
    execute_query($conn, $staff_kpi_table, "staff_kpi_table");

    // closing connection
    mysqli_close($conn);

    //executes sql query to create database/tables
    function execute_query($conn, $sql_query, $name) {
        if (mysqli_query($conn, $sql_query)) {
            echo "$name created OK";
        } else {
            echo "Error creating $name: " . mysqli_error($conn);
        }
    };
?>

