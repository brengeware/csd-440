<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan - Create Table</title>
</head>
<body>

<h1>Create Movies Table</h1>

<?php
/**
 * BrennanCreateTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440 
 * Date: 5/8/26
 * Description: Connects to the baseball_01 database and creates
 *              the movies table with at least 5 fields of varying data types.
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

// SQL statement to create the movies table
$sql = "CREATE TABLE movies (
    movie_id     INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(100) NOT NULL,
    genre        VARCHAR(50),
    release_year INT,
    rating       DECIMAL(3,1),
    watched      TINYINT(1) DEFAULT 0
)";

// Execute the query and display result
if (mysqli_query($conn, $sql)) {
    echo "<p>Table <strong>movies</strong> created successfully.</p>";
} else {
    echo "<p>Error creating table: " . mysqli_error($conn) . "</p>";
}

// Close the database connection
mysqli_close($conn);
echo "<p>Database connection closed.</p>";
?>

</body>
</html>