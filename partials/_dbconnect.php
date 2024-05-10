<?php
    // connect to mysql server
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'idiscuss';

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        # code...
        die('Unable to connect to database due to ---> ' .mysqli_connect_error());
    }

    // echo '<b>Connection successfull</b>';
?>