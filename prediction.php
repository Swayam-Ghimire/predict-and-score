<?php
include_once('header.php');
include('calculate_points.php');
include('database.php');
echo "<section id='main'>
    <div class='table_header'>
        <h1>Your Predictions and Points</h1>
    </div>
    <div class='table'>
        <table>";
try{
    if (!isset($uid) || !is_numeric($uid)){
        throw new Exception("User Id is not set or invalid.");
    }
    $matches = "SELECT m.id, m.match_name, m.date_time, m.actual_score, p.prediction, p.points FROM matches AS m LEFT JOIN predictions AS p ON m.id = p.match_id AND p.user_id = ? WHERE m.actual_score is NOT NULL AND m.date_time < NOW() ORDER BY m.date_time ASC";
    $stmt = $connection->prepare($matches);
    $stmt->bind_param("i", $uid);
    if (!$stmt->execute()) {
        throw new Exception("Database Query Failed: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $match[] = ['id'=> $row['id'],
                        'match_name' => $row['match_name'],
                        'date_time' => $row['date_time'],
                        'prediction' => $row['prediction'] ?? 'No Prediction',
                        'actual_score' => $row['actual_score'],
                        'points' => $row['points'] ?? 0];    
        }
    }
    else {
        throw new Exception("No matches found where you made predictions.");
    }
echo "<thead>
    <tr>
        <th class='head'>Id</th>
        <th class='head'>Match</th>
        <th class='head'>Date and Time</th>
        <th class='head'>Prediction</th>
        <th class='head'>Actual Score</th>
        <th class='head'>Points</th>
    </tr></thead>
    <tbody>";
            foreach ($match as $m){
                $matchId = $m['id'];
                $matchName = $m['match_name'];
                $dateTime = $m['date_time'];
                $actualScore = $m['actual_score'];
                $prediction = $m['prediction'];
                $points = $m['points'];
            
            echo "<tr>
                <td>{$matchId}</td>
                <td>{$matchName}</td>
                <td>{$dateTime}</td>
                <td>{$prediction}</td>
                <td>{$actualScore}</td>
                <td>{$points}</td>
                </tr>";
            }
}
catch (Exception $e){
    echo "<tr><td colspan='6'>Error: {$e->getMessage()}</td></tr>";
}
finally {
    if (isset($stmt)){
        $stmt->close();
    }
    $connection->close();
}
?>
</tbody>
</table>
</section>
</body>
</html>