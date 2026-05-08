<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan - Populate Table</title>
</head>
<body>

<h1>Populate Movies Table</h1>

<?php
/**
 * BrennanPopulateTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440
 * Date: 5/8/26
 * Description: Connects to the baseball_01 database and inserts
 *              sample records into the movies table.
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

// Array of INSERT statements for sample movie records
$inserts = [
    "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES ('Tommy Boy', 'Comedy', 1995, 7.1, 1)",
    "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES ('Interstellar', 'Sci-Fi', 2014, 8.6, 1)",
    "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES ('The Shawshank Redemption', 'Drama', 1994, 9.3, 1)",
    "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES ('Inception', 'Sci-Fi', 2010, 8.8, 1)",
    "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES ('Parasite', 'Thriller', 2019, 8.5, 0)",
    "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES ('The Godfather', 'Crime', 1972, 9.2, 0)"
];

// Loop through each insert and execute
foreach ($inserts as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "<p>Record inserted successfully.</p>";
    } else {
        echo "<p>Error inserting record: " . mysqli_error($conn) . "</p>";
    }
}

// Close the database connection
mysqli_close($conn);
echo "<p>Database connection closed.</p>";
?>

</body>
</html>