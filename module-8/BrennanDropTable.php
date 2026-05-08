<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan - Drop Table</title>
</head>
<body>

<h1>Drop Movies Table</h1>

<?php
/**
 * BrennanDropTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440
 * Date: 5/8/26
 * Description: Connects to the baseball_01 database and drops
 *              the movies table if it exists.
 */

// Database connection variables
$host     = "localhost";
$user     = "student1";
$password = "pass";
$database = "baseball_01";

// Establish connection to the database
$conn = mysqli_connect($host, $user, $password, $database);

// Check if connection was successful
if (!$conn) {
    die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
}

echo "<p>Connected to database successfully.</p>";

// SQL statement to drop the movies table if it exists
$sql = "DROP TABLE IF EXISTS movies";

// Execute the query and display result
if (mysqli_query($conn, $sql)) {
    echo "<p>Table <strong>movies</strong> dropped successfully (if it existed).</p>";
} else {
    echo "<p>Error dropping table: " . mysqli_error($conn) . "</p>";
}

// Close the database connection
mysqli_close($conn);
echo "<p>Database connection closed.</p>";
?>

</body>
</html>