<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    header('Location:index.html');
    exit();
}
include('database.php');
try{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $prediction = '';
        $uid = $_SESSION['user_id'];
        $match_id = $_POST['match_id'];
        if (!isset($match_id) || !is_numeric($match_id)){
            throw new Exception ("where is the match id?");
        }
        if (isset($_POST['submit_match'])){
            $prediction = trim(htmlspecialchars(stripslashes($_POST['prediction'])));
            if (!preg_match('/^\d+-\d+$/', $prediction)){
                throw new Exception("Invalid prediction format. Use 'home-away' format.");
            }
            $sql = "INSERT INTO predictions (user_id, `match_id`, prediction) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("iis", $uid, $match_id, $prediction);
            if (!$stmt->execute()) {
                throw new Exception("Database Error: " . $stmt->error);
            }
        }
        elseif (isset($_POST['edit_match'])){
            $sql2 = "DELETE FROM predictions WHERE user_id = ? AND match_id = ?";
            $stmt1 = $connection->prepare($sql2);
            $stmt1->bind_param("ii", $uid, $match_id);
            if( !$stmt1->execute()) {
                throw new Exception("Database Error: " . $stmt1->error);
            }

        }
    
}
    else{
        header('Location: home.php');
        exit();
    }

}
    catch (Exception $e){
        echo "<h5>Error: {$e->getMessage()}</h5>";
    }
    finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($stmt1)) {
            $stmt1->close();
        }
        $connection->close();
        header('Location: home.php');
    }
?>