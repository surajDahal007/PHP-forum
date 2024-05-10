<?php
$showErr = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "_dbconnect.php";

        $user_name = $_POST['username'];
        $user_email = $_POST['signupEmail'];
        $password = $_POST['signupPassword'];
        $cpassword = $_POST['signupcPassword'];

        // check whether username exist in db
        $sql = "SELECT * from users where user_name = '$user_name'";
        $result = mysqli_query($conn, $sql);
        $numRows1 = mysqli_num_rows($result);

        if ($numRows1>0) {
            $showErr = "This username is already in use. Choose another username";
        }
        else {
            // check whether email exist in db 
            $sql = "SELECT * from users where user_email = '$user_email'";
            $result = mysqli_query($conn, $sql);
            $numRows2 = mysqli_num_rows($result);

            if ($numRows2>0) {
                $showErr = "This email is already in use";
            }
            else {
                if ($password == $cpassword) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `timestamp`) VALUES ('$user_name', '$user_email', '$hash', current_timestamp())";
                    $result = mysqli_query($conn, $sql);
    
                    if ($result) {
                        $showAlert = true;
                        // header("Location: /forum/index.php?signupsuccess=true");
                        header("Location: /forum/index.php?signupsuccess");
                        exit();
                    }
                }
                else {
                    $showErr = "Passwords do not match";
                }
            }

        }
        header("Location: /forum/index.php?error=$showErr");
    }
?>