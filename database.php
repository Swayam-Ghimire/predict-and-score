<?php
$db_server = 'localhost';
$db_user = "root";
$db_pass = "";
$db_name = "predication_game";
$conn = "";
try{
    // Connecting to the database
    $connection = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
}
catch (mysqli_sql_exception $e){
    echo "Error:" . $e->getMessage();
}
if ($connection){
    echo "You are connected" . '<br>' ;
}
?>