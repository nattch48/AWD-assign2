<?php
    $notUser = false;
    //check if user is logged in

    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $user_type = $_SESSION['type'];

        if ($user_type == 'admin') {
            $notUser = true;
            function_alert("Access denied! Please log in as a USER to access this page");
            
        }
    } else {
        $notUser = true;
        function_alert("Please log in to proceed.");        
    }

    function function_alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');
        window.location.href='../Admin/login.php';
        </script>";
    }

?>