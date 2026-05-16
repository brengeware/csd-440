<?php
/**
 * BrennanQueryTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440 - Module 9
 * Description: Queries all records from the movies table in baseball_01
 *              and displays them sorted by rating in descending order.
 */

$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "baseball_01";

$conn = new mysqli($host, $user, $pass, $dbname);

$messages = [];
$rows     = [];

if ($conn->connect_error) {
    $messages[] = ["type" => "error", "text" => "Connection failed: " . $conn->connect_error];
} else {
    $messages[] = ["type" => "success", "text" => "Connected to database successfully."];

    $result = $conn->query("SELECT movie_id, title, genre, release_year, rating, watched FROM movies ORDER BY rating DESC");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->free();
    } else {
        $messages[] = ["type" => "error", "text" => "Query failed: " . $conn->error];
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
    <title>Brennan Query Table</title>
    <?php include '_style.php'; ?>
</head>
<body>
<div class="container" style="max-width:860px">
    <a class="back-link" href="BrennanIndex.php">← Back to Index</a>
    <h1>Query Movies Table</h1>
    <p class="subtitle">All movies, sorted by rating (highest first)</p>

    <div class="card" style="padding: 20px 24px;">
        <?php foreach ($messages as $msg): ?>
            <p class="msg msg-<?php echo $msg['type']; ?>"><?php echo $msg['text']; ?></p>
        <?php endforeach; ?>

        <?php if (!empty($rows)): ?>
            <p class="msg msg-info" style="margin-top:4px;">
                Total movies found: <strong style="color:#f5c518"><?php echo count($rows); ?></strong>
            </p>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Year</th>
                        <th>Rating</th>
                        <th>Watched</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo $row['movie_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['genre']); ?></td>
                            <td><?php echo $row['release_year']; ?></td>
                            <td><span class="rating-badge"><?php echo $row['rating']; ?></span></td>
                            <td class="<?php echo $row['watched'] ? 'watched-yes' : 'watched-no'; ?>">
                                <?php echo $row['watched'] ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>