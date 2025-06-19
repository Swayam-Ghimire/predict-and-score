<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Liverpool, prediction game, football, liverpool football, registration">
    <meta name="description" content="registration and login system">
    <meta name="author" content="Swayam Ghimire">
    <?php 
    if (basename($_SERVER['PHP_SELF']) == '../views/leaderboard.php'){
        echo "<title>Leaderboards</title>";
        }
    elseif (basename($_SERVER['PHP_SELF']) == '../views/prediction.php'){
        echo "<title>Your Predictions</title>";
    }
    else {
        echo "<title>Upcoming Fixtures</title>";
    }
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div id="logo">
                <a href="../views/prediction.php">
                    <img src="../assets/images/liverpoollogo.png" alt="logo">
                </a>
            </div>
            <ul>
                <li class="item"><a href="../views/home.php">Fixtures</a></li>
                <li class="item"><a href="../views/leaderboard.php">Leaderboard</a></li>
                <li class="item"><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>