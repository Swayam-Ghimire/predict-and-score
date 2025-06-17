<?php
include('../includes/verify.php');
include('../includes/database.php');
$uid = $_SESSION['user_id'];

function calculatePoints($predictionScore, $actualScore, $matchId){
    global $connection;
    global $uid;
    $predictionParts = explode('-', $predictionScore);
    $actualParts = explode('-', $actualScore);
    $predictionHome = (int)$predictionParts[0];
    $predictionAway = (int)$predictionParts[1];
    $actualHome = (int)$actualParts[0];
    $actualAway = (int)$actualParts[1];
    if ($predictionScore === $actualScore) {
        $points = 3;
    } elseif (($predictionHome > $predictionAway && $actualHome > $actualAway) || ($predictionAway > $predictionHome && $actualAway > $actualHome || ($predictionHome === $predictionAway && $actualHome === $actualAway))){
        $points = 2;
    }
    else {  
        $points = 1;
    }
    $sql = "UPDATE predictions SET points = ? WHERE user_id = ? AND match_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database Errror: " . $connection->error);
    }
    $stmt->bind_param("iii", $points, $uid, $matchId);
    if (!$stmt->execute()) {
        throw new Exception("Database Error: " . $stmt->error);
    }
    $stmt->close();
}

function getUserPredictions($connection, $uid) {
    global $connection;
    global $uid;
    $sql = "SELECT m.id, p.prediction, m.actual_score FROM predictions AS p JOIN matches AS m ON p.match_id = m.id AND p.user_id = ? WHERE m.actual_score IS NOT NULL AND m.date_time < NOW() ORDER BY m.date_time ASC";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database Error: " . $connection->error);
    }
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        throw new Exception("Database Query Failed: " . $connection->error);
    }
    $stmt->close();
    return $result;
}


try{
    $result = getUserPredictions($connection, $uid);
    $predictions = [];
    $actualScores = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            calculatePoints($row['prediction'], $row['actual_score'], $row['id']);
        }
    }
    else {
        throw new Exception("No predictions found for user ID:");
    }
}

catch (Exception $e){
    echo "Error: " . $e->getMessage();
}
finally {
    $connection->close();
}
?>