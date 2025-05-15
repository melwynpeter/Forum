<?php
// $err = "false";
$showAlert = false;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $user_password = $_POST['signupPassword'];
    $user_cpassword = $_POST['signupcPassword'];

    // Check if this email exists
    $sql = "SELECT * FROM `users` WHERE `user_email` = '$user_email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0){
        $err = "This email is in use";
        echo $err;
    }
    else{
            if($user_password == $user_cpassword){
                    $hash = password_hash($user_password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`user_email`, `user_password`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
                    $result = mysqli_query($conn, $sql);
                    if(!$result){
                        echo "Record not inserted successfully" . mysqli_error($conn) . "<br>";
                    }
                    else{
                        $showAlert = true;
                        header('location: /forum/index.php?signupsuccess=true');
                        exit();
                    }
            }
            else{
                $err = "Passwords do not match";
                echo $err;
            }
    }
    header("location: /forum/index.php?signupsuccess=false&error=$err");

}
?>