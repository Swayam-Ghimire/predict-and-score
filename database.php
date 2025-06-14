<?php
$db_server = 'localhost';
$db_user = "root";
$db_pass = "";
$db_name = "prediction_game";
$conn = "";
try{
    // Connecting to the database
    $connection = new mysqli($db_server, $db_user, $db_pass, $db_name);
}
catch (mysqli_sql_exception $e){
    echo "Error:" . $e->getMessage();
}
?>