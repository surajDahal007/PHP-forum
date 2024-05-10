<?php
    $showErr = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '_dbconnect.php';

        $email = $_POST['loginEmail'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `users` WHERE user_email = '$email'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);

        if ($numRows==1) {
            $row = mysqli_fetch_assoc($result);
            // echo $password;
            // echo password_hash($password, PASSWORD_DEFAULT);
            // echo '<br>';
            // echo $row['user_password'];
            // echo '<br>';
            // echo var_dump(password_verify($password, $row['user_password']));
          
            if (password_verify($password, $row['user_password'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['userEmail'] = $email;
                // echo '<h1>Loggedin </h1>';                    
                header("Location: /forum/index.php?loginSuccess");
            }else {
                header("Location: /forum/index.php?loginFailure");
                // password didn't match
            }
        }
        else {
            $showErr = "Email does not exist.";
            header("Location: /forum/index.php?error=$showErr");

        }
     
    }
?>