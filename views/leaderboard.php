<?php
include('../includes/verify.php');
include_once('../includes/header.php');
include('../includes/database.php');
$uid = $_SESSION['user_id'];
$sql = "SELECT CONCAT(u.first_name, ' ', u.last_name) AS username, u.id, SUM(p.points) AS total_points FROM users u JOIN predictions AS p ON u.id = p.user_id GROUP BY u.id ORDER BY total_points DESC LIMIT 10";
?>
<div class="wrapper">

    <section id="main">
        <div class="table_header">
            <h1>Current Ranking</h1>
        </div>
        <div class="table">
            <table>
                <thead>
                    <th class="head">Rank</th>
                    <th class="head">User Names</th>
                    <th class="head">Points</th>
                </thead>
                <tbody>
                    <?php
                    try{
                        $result = $connection->query($sql);
                        if (!$result){
                            throw new Exception("Database Query Failed: " . $connection->error);
                        }
                        if ($result->num_rows > 0) {
                            $rank = 1;
                            while ($row = $result->fetch_assoc()) {
                                if ($row['id'] == $uid) {
                                    echo "<tr class='highlight'>";
                                }
                                else {
                                    echo "<tr>";
                                }
                                echo "
                                      <td>{$rank}</td>
                                      <td>{$row['username']}</td>
                                      <td>{$row['total_points']}</td>
                                      </tr>";
                                      $rank++;
                            }
                        }
                    }
                    catch(Exception $e){
                        echo "<tr><td colspan='3'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                    finally{
                        if ($connection) {
                            $connection->close();
                        }
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php include_once('../includes/footer.php'); ?>