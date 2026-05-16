<?php
/**
 * BrennanCreateTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440 - Module 8
 * Description: Creates the movies table in the baseball_01 database using MySQLi.
 *              Columns: movie_id (PK AUTO_INCREMENT), title, genre, release_year, rating, watched.
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

    $sql = "CREATE TABLE IF NOT EXISTS movies (
        movie_id     INT AUTO_INCREMENT PRIMARY KEY,
        title        VARCHAR(255) NOT NULL,
        genre        VARCHAR(100) NOT NULL,
        release_year INT NOT NULL,
        rating       DECIMAL(3,1) NOT NULL,
        watched      TINYINT(1) DEFAULT 0
    )";

    if ($conn->query($sql) === TRUE) {
        $messages[] = ["type" => "success", "text" => "Table <strong>movies</strong> created successfully."];
    } else {
        $messages[] = ["type" => "error", "text" => "Error creating table: " . $conn->error];
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
    <title>Brennan Create Table</title>
    <?php include '_style.php'; ?>
</head>
<body>
<div class="container">
    <a class="back-link" href="BrennanIndex.php">← Back to Index</a>
    <h1>Create Movies Table</h1>
    <p class="subtitle">Creates the movies table in baseball_01</p>
    <div class="card">
        <?php foreach ($messages as $msg): ?>
            <p class="msg msg-<?php echo $msg['type']; ?>"><?php echo $msg['text']; ?></p>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>