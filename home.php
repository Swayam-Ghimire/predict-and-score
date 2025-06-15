<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    header('Location: index.html');
    exit();
}
include('database.php');
$uid = $_SESSION['user_id'];
$matches = "SELECT * FROM matches ORDER BY date_time ASC";
$result = $connection->query($matches);
if (!$result) {
    throw new Exception("Database Query Failed: " . $connection->error);
}
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $match[] = [
            'id' => $row['id'],
            'match_name' => $row['match_name'],
            'date_time' => $row['date_time'],
            'actual_score' => $row['actual_score']
        ];
    }
} else {
    $match = [];
}
include_once('header.php');
?>
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
                    <?php
                    try {
                        if (empty($match)) {
                            throw new Exception("No matches found.");
                        } else {
                            foreach ($match as $m) {
                                $matchId = $m['id'];
                                $isLocked = is_null($m['actual_score']);
                                echo "<tr><form action='process_prediction.php' method='POST'>
                                <td>{$matchId}</td>
                                <td>{$m['match_name']}</td>
                                <td>{$m['date_time']}</td>
                                <td><input type='hidden' name='match_id' value='{$matchId}'>";
                                $predictionQuery = "SELECT prediction FROM predictions WHERE user_id = ? AND match_id = ?";
                                $stmt = $connection->prepare($predictionQuery);
                                $stmt->bind_param('ii', $uid, $matchId);
                                $stmt->execute();
                                $predictionResult = $stmt->get_result();
                                $stmt->close();
                                $prediction = '';
                                if (!$predictionResult) {
                                    throw new Exception ("Database Query Failed: " . $connection->error);
                                }
                                if ($predictionResult->num_rows > 0) {
                                    $predictionRow = $predictionResult->fetch_assoc();
                                    $prediction = $predictionRow['prediction'];
                                }
                                if ($isLocked) {
                                    echo $prediction != '' ? $prediction : "<input type='text' class='prediction' name='prediction' max-length='6' size='31' placeholder='Enter you prediction format: (home-away)'>";
                                }
                                else {
                                    echo $prediction != '' ? $prediction : 'Locked';
                                }
                                echo "</td>
                                <td>";
                                if ($prediction == '' && $isLocked){
                                    echo "<button type='submit' name='submit_match' value='submit' class='action-btn'>Submit</button>";
                                }
                                elseif ($prediction != '' && $isLocked){
                                    echo "<button type='submit' name='edit_match' value='edit' class='action-btn'>Edit</button>";
                                }
                                else {
                                    echo "<button class='action-btn' disabled>Locked</button>";
                                }
                                echo "</td></form></tr>";
                            }
                        }
                    } catch (Exception $e) {
                        echo "<tr><td colspan='5'>Error: {$e->getMessage()}</td></tr>";
                    } finally {
                        if (isset($connection)) {
                            $connection->close();
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer></footer>
    <script src="script.js"></script>
</body>

</html>