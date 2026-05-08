<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan - Query Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>

<h1>Query Movies Table</h1>

<?php
/**
 * BrennanQueryTable.php
 * Author: Brennan Cheatwood
 * Course: CSD440
 * Date: 5/8/26
 * Description: Connects to the baseball_01 database, queries all records
 *              from the movies table, and displays them in an HTML table.
 *              Uses mysqli_num_rows to show total count and
 *              mysqli_fetch_array to loop through results.
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

// SQL query to select all movies ordered by rating descending
$sql = "SELECT * FROM movies ORDER BY rating DESC";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if query returned results
if (!$result) {
    die("<p>Query failed: " . mysqli_error($conn) . "</p>");
}

// Use mysqli_num_rows to get and display total record count
$rowCount = mysqli_num_rows($result);
echo "<p>Total movies found: <strong>" . $rowCount . "</strong></p>";

// Display results in an HTML table if rows were returned
if ($rowCount > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Title</th>
            <th>Genre</th>
            <th>Release Year</th>
            <th>Rating</th>
            <th>Watched</th>
          </tr>";

    // Loop through each row using mysqli_fetch_array
    while ($row = mysqli_fetch_array($result)) {
        $watched = ($row["watched"] == 1) ? "Yes" : "No";

        echo "<tr>";
        echo "<td>" . $row["movie_id"]     . "</td>";
        echo "<td>" . $row["title"]        . "</td>";
        echo "<td>" . $row["genre"]        . "</td>";
        echo "<td>" . $row["release_year"] . "</td>";
        echo "<td>" . $row["rating"]       . "</td>";
        echo "<td>" . $watched             . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No records found in the movies table.</p>";
}

// Close the database connection
mysqli_close($conn);
echo "<p>Database connection closed.</p>";
?>

</body>
</html>