<?php
include('database.php');

// Checking if the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $first_name = $_POST['first'];
    $last_name = $_POST['last'];
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    if(empty($first_name) || empty($last_name) || empty($email) || empty($password)){
        echo "Please fill in all fields";
    }
    else{
        // Inserting data into the database
        $query = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
        $result = mysqli_query($connection, $query);
        if($result){
            echo "User registered successfully";
        }
        else{
            echo "Error registering user";
        }
    }
    // Closing the connection
    mysqli_close($connection);
}
?>