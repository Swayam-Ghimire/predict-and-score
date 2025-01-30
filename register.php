<?php
include('database.php');
function sanitize_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    return $data;
}

function validate_email($email){
    global $connection;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email format";
    }
    else{
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0){
            echo "Email already exists";
        }
}
}
// Checking if the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SignUp'])){
    $first_name = sanitize_input($_POST['first']);
    $last_name = sanitize_input($_POST['last']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    validate_email($email);
    if(empty($first_name) || empty($last_name) || empty($email) || empty($password)){
        echo "Please fill in all fields";
    }
    else{
        // Inserting data into the database
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
        try{
            mysqli_query($connection, $sql);
            header('Location: index.html');
            exit();
        }
        catch(mysqli_sql_exception $e){
            echo "Error: {$e->getMessage()}";
        }
    }
    // Closing the connection
    mysqli_close($connection);
}
?>