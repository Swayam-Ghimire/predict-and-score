<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Liverpool, prediction game, football, liverpool football, registration">
    <meta name="description" content="registration and login system">
    <meta name="author" content="Swayam Ghimire">
    <title>Upcoming Fixtures</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div id="logo">
                <img src="images/liverpool.jpg" alt="logo">
            </div>
            <ul>
                <li class="item"><a href="#main">Fixtures</a></li>
                <li class="item"><a href="#">Leaderboard</a></li>
                <li class="item"><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section id="main">
    <div class="table_header">
        <h1>Upcoming Fixtures</h1>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th class="head">Id</th>
                    <th class="head">Match</th>
                    <th class="head">Date and Time</th>
                    <th class="head">Prediction</th>
                    <th class="head">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Team A vs Team B</td>
                    <td>2025-01-30 18:00</td>
                    <td>Team A Wins</td>
                    <td>
                        <button class="action-btn">Edit</button>
                        <button class="action-btn">Submit</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Team C vs Team D</td>
                    <td>2025-02-05 20:00</td>
                    <td>Draw</td>
                    <td>
                        <button class="action-btn">Edit</button>
                        <button class="action-btn">Submit</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
</body>

</html>
