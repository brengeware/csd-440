<?php
/**
 * BrennanIndex.php
 * Author: Brennan Cheatwood
 * Course: CSD440 - Module 9
 * Date: <?php echo date('m/d/Y'); ?>
 * Description: Index page with navigation links to all movie database PHP pages.
 */

// Test database connection for status indicator
$conn = new mysqli("localhost", "root", "", "baseball_01");
$dbConnected = ($conn->connect_error === null);
if ($dbConnected) $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan's Movie Database</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #0d0d0d;
            color: #e8e8e8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
        }

        header {
            text-align: center;
            margin-bottom: 60px;
        }

        header h1 {
            font-size: 3rem;
            letter-spacing: 0.05em;
            color: #f5c518;
            text-transform: uppercase;
        }

        header p {
            margin-top: 10px;
            font-size: 1rem;
            color: #888;
            letter-spacing: 0.1em;
        }

        .section-label {
            font-size: 0.7rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #555;
            margin-bottom: 16px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 900px;
            margin-bottom: 50px;
        }

        .card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-left: 3px solid #f5c518;
            border-radius: 6px;
            padding: 22px 24px;
            text-decoration: none;
            color: #e8e8e8;
            transition: border-left-color 0.2s, background 0.2s;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .card:hover {
            background: #1f1f1f;
            border-left-color: #fff;
        }

        .card .card-title {
            font-size: 1rem;
            font-weight: bold;
            color: #f5c518;
        }

        .card .card-desc {
            font-size: 0.82rem;
            color: #888;
            line-height: 1.5;
        }

        footer {
            margin-top: auto;
            padding-top: 40px;
            font-size: 0.75rem;
            color: #444;
            letter-spacing: 0.08em;
        }

        .db-indicator {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-top: 14px;
        }

        .db-indicator .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .db-connected .dot { background: #4caf80; box-shadow: 0 0 6px #4caf80; }
        .db-connected span { color: #4caf80; }
        .db-disconnected .dot { background: #e06060; box-shadow: 0 0 6px #e06060; }
        .db-disconnected span { color: #e06060; }
    </style>
</head>
<body>

    <header>
        <h1>Movie Database</h1>
        <p>Brennan Cheatwood &mdash; CSD440 Module 9</p>
        <div class="db-indicator <?php echo $dbConnected ? 'db-connected' : 'db-disconnected'; ?>">
            <div class="dot"></div>
            <span><?php echo $dbConnected ? 'Connected to Database' : 'Database Unavailable'; ?></span>
        </div>
    </header>

    <p class="section-label">Module 9 &mdash; New Pages</p>
    <div class="card-grid">
        <a class="card" href="BrennanQuery.php">
            <div class="card-title">Search Movies</div>
            <div class="card-desc">Search the movies table by title, genre, release year, or rating.</div>
        </a>
        <a class="card" href="BrennanAddForm.php">
            <div class="card-title">Add a Movie</div>
            <div class="card-desc">Submit a form to insert a new movie record into the database.</div>
        </a>
    </div>

    <p class="section-label">Module 8 &mdash; Database Utilities</p>
    <div class="card-grid">
        <a class="card" href="BrennanCreateTable.php">
            <div class="card-title">Create Table</div>
            <div class="card-desc">Creates the movies table in the baseball_01 database.</div>
        </a>
        <a class="card" href="BrennanPopulateTable.php">
            <div class="card-title">Populate Table</div>
            <div class="card-desc">Inserts the default set of 6 movies into the table.</div>
        </a>
        <a class="card" href="BrennanQueryTable.php">
            <div class="card-title">Query All Movies</div>
            <div class="card-desc">Displays all movies sorted by rating in descending order.</div>
        </a>
        <a class="card" href="BrennanDropTable.php">
            <div class="card-title">Drop Table</div>
            <div class="card-desc">Drops the movies table from the database if it exists.</div>
        </a>
    </div>

    <footer>
        CSD440 &mdash; Server-Side Scripting &mdash; Brennan Cheatwood
    </footer>

</body>
</html>