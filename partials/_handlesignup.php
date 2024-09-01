<?php 
    $showError = "false";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include '_dbconnect.php';
        $user_email = $_POST['signupEmail'];
        $user_name = $_POST['signupName'];
        $pass = $_POST['signupPassword'];
        $cpass = $_POST['signupcPassword'];

        // check wheather this email exists
        $existSql = "SELECT * FROM `users` WHERE user_email = '$user_email' or user_name = '$user_name'";
        $result = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($result);

        if($numRows > 0) $showError = "Email or Name already in use";
        else {
            if($pass == $cpass) {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                //$sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
                $sql = "INSERT INTO `users` (`user_email`, `user_name`, `user_pass`, `timestamp`) VALUES ('$user_email', '$user_name', '$hash', current_timestamp())";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    $showAlert = true;
                    header("Location: /forum/index.php?signupResponse=1");
                    exit();
                }
            }
            else {
                $showError = "Password do not match";
            }
        }
        header("Location: /forum/index.php?signupResponse=$showError");
    }
?>