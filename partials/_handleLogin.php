<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    include "_dbconnect.php";
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $sql = "SELECT * FROM `users` WHERE `user_email` = '$email'";
    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);
    if($num == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['user_password'])){
            echo "login successful <br>";
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['useremail'] = $row['user_email'];
        }
        header("location: /forum/index.php");
    }
    header("location: /forum/index.php");
}
?>