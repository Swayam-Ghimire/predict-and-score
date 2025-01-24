<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = filter_var(trim($_POST['pass']), FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate user input
    $errors = [];

    if (empty($email)) {
        $errors[] = "Username is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        // Proceed with login logic (e.g., check credentials in the database)
        // ...
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>