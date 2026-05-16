<?php
/**
 * BrennanAddForm.php
 * Author: Brennan Cheatwood
 * Course: CSD440 - Module 9
 * Date: <?php echo date('m/d/Y'); ?>
 * Description: Form page that allows users to add a new movie record to the
 *              movies table in the baseball_01 database using a POST form.
 */

$success = false;
$error   = "";

// --- Handle form submission ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize and validate inputs
    $title        = trim($_POST["title"] ?? "");
    $genre        = trim($_POST["genre"] ?? "");
    $release_year = (int)($_POST["release_year"] ?? 0);
    $rating       = (float)($_POST["rating"] ?? 0);
    $watched      = isset($_POST["watched"]) ? 1 : 0;

    if ($title === "") {
        $error = "Title is required.";
    } elseif ($genre === "") {
        $error = "Genre is required.";
    } elseif ($release_year < 1888 || $release_year > 2099) {
        $error = "Please enter a valid release year (1888–2099).";
    } elseif ($rating < 0 || $rating > 10) {
        $error = "Rating must be between 0 and 10.";
    } else {
        // Connect and insert
        $host   = "localhost";
        $user   = "root";
        $pass   = "";
        $dbname = "baseball_01";

        $conn = new mysqli($host, $user, $pass, $dbname);

        if ($conn->connect_error) {
            $error = "Connection failed: " . $conn->connect_error;
        } else {
            $sql  = "INSERT INTO movies (title, genre, release_year, rating, watched) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssidi", $title, $genre, $release_year, $rating, $watched);

            if ($stmt->execute()) {
                $success = true;
            } else {
                $error = "Insert failed: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan Add Movie – Movie Database</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #0d0d0d;
            color: #e8e8e8;
            min-height: 100vh;
            padding: 50px 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-block;
            color: #888;
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 0.12em;
            margin-bottom: 30px;
            text-transform: uppercase;
        }
        .back-link:hover { color: #f5c518; }

        h1 {
            font-size: 2.4rem;
            color: #f5c518;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            margin-bottom: 40px;
        }

        .card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 6px;
            padding: 36px 32px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 22px;
        }

        label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #888;
        }

        input[type="text"],
        input[type="number"] {
            background: #111;
            border: 1px solid #333;
            border-radius: 4px;
            padding: 11px 13px;
            color: #e8e8e8;
            font-size: 0.9rem;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            transition: border-color 0.2s;
            width: 100%;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #f5c518;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #f5c518;
            cursor: pointer;
        }

        .checkbox-group label {
            font-size: 0.85rem;
            text-transform: none;
            letter-spacing: 0.03em;
            color: #ccc;
            cursor: pointer;
        }

        button[type="submit"] {
            width: 100%;
            background: #f5c518;
            color: #0d0d0d;
            border: none;
            border-radius: 4px;
            padding: 13px;
            font-size: 0.9rem;
            font-weight: bold;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover { background: #e6b800; }

        /* Alerts */
        .alert {
            border-radius: 4px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 0.87rem;
            line-height: 1.5;
        }

        .alert-success {
            background: #0d2b1a;
            border: 1px solid #1e5c34;
            color: #4caf80;
        }

        .alert-error {
            background: #2b0d0d;
            border: 1px solid #5c1e1e;
            color: #e06060;
        }

        .alert a {
            color: inherit;
            font-weight: bold;
        }

        .divider {
            border: none;
            border-top: 1px solid #2a2a2a;
            margin: 28px 0;
        }
    </style>
</head>
<body>
<div class="container">

    <a class="back-link" href="BrennanIndex.php">← Back to Index</a>

    <h1>Add a Movie</h1>
    <p class="subtitle">Insert a new record into the movies table</p>

    <div class="card">

        <?php if ($success): ?>
            <div class="alert alert-success">
                ✓ Movie added successfully!
                &nbsp;<a href="BrennanAddForm.php">Add another</a> or
                <a href="BrennanQueryTable.php">view all movies</a>.
            </div>
            <hr class="divider">
        <?php elseif ($error !== ""): ?>
            <div class="alert alert-error">
                ✗ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="BrennanAddForm.php">

            <div class="form-group">
                <label for="title">Title <span style="color:#e06060">*</span></label>
                <input type="text" id="title" name="title" required
                       placeholder="e.g. The Dark Knight"
                       value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre <span style="color:#e06060">*</span></label>
                <input type="text" id="genre" name="genre" required
                       placeholder="e.g. Action"
                       value="<?php echo htmlspecialchars($_POST['genre'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="release_year">Release Year <span style="color:#e06060">*</span></label>
                <input type="number" id="release_year" name="release_year" required
                       min="1888" max="2099" placeholder="e.g. 2008"
                       value="<?php echo htmlspecialchars($_POST['release_year'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="rating">Rating (0–10) <span style="color:#e06060">*</span></label>
                <input type="number" id="rating" name="rating" required
                       min="0" max="10" step="0.1" placeholder="e.g. 9.0"
                       value="<?php echo htmlspecialchars($_POST['rating'] ?? ''); ?>">
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="watched" name="watched"
                       <?php echo isset($_POST['watched']) ? 'checked' : ''; ?>>
                <label for="watched">I have watched this movie</label>
            </div>

            <button type="submit">Add Movie</button>

        </form>
    </div>

</div>
</body>
</html>