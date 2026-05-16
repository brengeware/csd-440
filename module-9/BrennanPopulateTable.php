<?php
/**
 * BrennanPopulateTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440 - Module 8
 * Description: Inserts 6 default movie records into the movies table
 *              in the baseball_01 database using MySQLi prepared statements.
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

    // Movie data: [title, genre, release_year, rating, watched]
    $movies = [
        ["Tommy Boy",               "Comedy",  1995, 7.1, 1],
        ["Interstellar",            "Sci-Fi",  2014, 8.6, 1],
        ["The Shawshank Redemption","Drama",   1994, 9.3, 1],
        ["Inception",               "Sci-Fi",  2010, 8.8, 1],
        ["Parasite",                "Thriller",2019, 8.5, 0],
        ["The Godfather",           "Crime",   1972, 9.2, 0],
    ];

    $sql  = "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $messages[] = ["type" => "error", "text" => "Prepare failed: " . $conn->error];
    } else {
        foreach ($movies as $movie) {
            $stmt->bind_param("ssidi", $movie[0], $movie[1], $movie[2], $movie[3], $movie[4]);
            if ($stmt->execute()) {
                $messages[] = ["type" => "success", "text" => "Record inserted: <strong>" . htmlspecialchars($movie[0]) . "</strong>"];
            } else {
                $messages[] = ["type" => "error", "text" => "Insert failed for " . htmlspecialchars($movie[0]) . ": " . $stmt->error];
            }
        }
        $stmt->close();
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
    <title>Brennan Populate Table</title>
    <?php include '_style.php'; ?>
</head>
<body>
<div class="container">
    <a class="back-link" href="BrennanIndex.php">← Back to Index</a>
    <h1>Populate Movies Table</h1>
    <p class="subtitle">Inserts 6 default movie records into baseball_01</p>
    <div class="card">
        <?php foreach ($messages as $msg): ?>
            <p class="msg msg-<?php echo $msg['type']; ?>"><?php echo $msg['text']; ?></p>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>