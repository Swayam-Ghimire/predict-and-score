<?php
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
            if($row['email'] == $email && password_verify($password, $row['password'])){
                header('Location: home.php');
            }
            else{
                echo "Invalid email or password";
            }
        }
        else{
            die("No user found with that email");
        }
    }
    // Closing the connection
    mysqli_close($connection);
}
?>