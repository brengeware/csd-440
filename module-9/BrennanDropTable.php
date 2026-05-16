<?php
/**
 * BrennanDropTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440 - Module 8
 * Description: Drops the movies table from the baseball_01 database if it exists.
 */

$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "baseball_01";

$conn = new mysqli($host, $user, $pass, $dbname);

$messages = [];

if ($conn->connect_error) {
    $messages[] = ["type" => "error", "text" => "Connection failed: " . $conn->connect_error];
} else {
    $messages[] = ["type" => "success", "text" => "Connected to database successfully."];

    $sql = "DROP TABLE IF EXISTS movies";

    if ($conn->query($sql) === TRUE) {
        $messages[] = ["type" => "success", "text" => "Table <strong>movies</strong> dropped successfully (if it existed)."];
    } else {
        $messages[] = ["type" => "error", "text" => "Error dropping table: " . $conn->error];
    }

    $conn->close();
    $messages[] = ["type" => "info", "text" => "Database connection closed."];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan Drop Table</title>
    <?php include '_style.php'; ?>
</head>
<body>
<div class="container">
    <a class="back-link" href="BrennanIndex.php">← Back to Index</a>
    <h1>Drop Movies Table</h1>
    <p class="subtitle">Removes the movies table from baseball_01</p>
    <div class="card">
        <?php foreach ($messages as $msg): ?>
            <p class="msg msg-<?php echo $msg['type']; ?>"><?php echo $msg['text']; ?></p>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>