<?php
session_start();
include('database.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['pass'];
    if(empty($email) || empty($password)){
        echo "Please fill in all fields";
    }
    else{
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row['password'])){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['logged_in'] = true;
                header('Location: home.php');
                exit();
            }
            else{
                echo "Invalid password";
                $_SESSION['logged_in'] = false;
                sleep(5);
            }
        }
    }
    // Closing the connection
    mysqli_close($connection);
}
header('Location: index.html');
?>