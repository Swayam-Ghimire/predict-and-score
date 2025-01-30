<?php
session_start();
include('database.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['LogIn'])){
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
            }
        }
    }
    // Closing the connection
    mysqli_close($connection);
}
?>
<meta http-equiv="refresh" content="5; url=http://localhost:8000/index.html">