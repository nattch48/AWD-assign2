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
        <?php include_once '../functions/db_conn.php'; ?>
        <section class="container">
            <br/>
            <h1 class="title">KPI Assignment System</h1>
            <br/>
            <div>
                <img class="me" src="../images/me.jpg" alt="Natasia Ting">
            </div>
            <br/>
            <!-- image goes here -->
            <p><strong>Name: </strong>Natasia Ting</p>
            <p><strong>Student ID: </strong>101235874</p>
            <p><strong>Email: </strong><a href="mailto:101235874@students.swinburne.edu.my">101235874@students.swinburne.edu.my</a></p>
            <br/>
            <p>I declare that this assignment is my individual work. I have not work 
            collaboratively nor have I copied from any other student's work or from any other source. 
            I have not engaged another party to complete this assignment. I am aware of the 
            University’s policy with regards to plagiarism. I have not allowed, and will not allow, 
            anyone to copy my work with the intention of passing it off as his or her own work.</p>
        
        </section>
        <br/><br/>
        
    </body>
    <footer class="footer">
        <p><a href="login.php">Login</a> | 
        <a href="../about.php">About This Assignment</a>
        <br/>
    </footer>

</html>