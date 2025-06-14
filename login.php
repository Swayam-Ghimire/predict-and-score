<?php
session_start();
include('database.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['LogIn'])){
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['pass'];
    if(empty($email) || empty($password)){
        echo "Please fill in all fields";
    }
    else{
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $connection->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['logged_in'] = true;
                header('Location: home.php');
            }
            else{
                echo "Invalid password";
            }
        }
    }
    // Closing the connection
    $connection->close();
    exit();
}
?>
<meta http-equiv="refresh" content="5; url=http://localhost:8000/index.html">