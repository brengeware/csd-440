<?php
/**
 * BrennanQuery.php
 * Author: Brennan Cheatwood
 * Course: CSD440 - Module 9
 * Date: <?php echo date('m/d/Y'); ?>
 * Description: Allows users to search the movies table by title, genre,
 *              minimum rating, or release year. Displays matching results in a table.
 */

// --- Database connection ---
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "baseball_01";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// --- Handle search ---
$results    = null;
$totalFound = 0;
$searched   = false;

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["search"])) {
    $searched = true;

    // Sanitize inputs
    $title        = trim($_GET["title"] ?? "");
    $genre        = trim($_GET["genre"] ?? "");
    $release_year = trim($_GET["release_year"] ?? "");
    $min_rating   = trim($_GET["min_rating"] ?? "");

    // Build dynamic WHERE clause
    $conditions = [];
    $params     = [];
    $types      = "";

    if ($title !== "") {
        $conditions[] = "title LIKE ?";
        $params[]     = "%" . $title . "%";
        $types       .= "s";
    }
    if ($genre !== "") {
        $conditions[] = "genre LIKE ?";
        $params[]     = "%" . $genre . "%";
        $types       .= "s";
    }
    if ($release_year !== "") {
        $conditions[] = "release_year = ?";
        $params[]     = (int)$release_year;
        $types       .= "i";
    }
    if ($min_rating !== "") {
        $conditions[] = "rating >= ?";
        $params[]     = (float)$min_rating;
        $types       .= "d";
    }

    $sql = "SELECT movie_id, title, genre, release_year, rating, watched FROM movies";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " ORDER BY rating DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $results    = $stmt->get_result();
    $totalFound = $results->num_rows;

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan Query – Movie Search</title>
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
            max-width: 960px;
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

        /* Search Form */
        .search-form {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 6px;
            padding: 30px;
            margin-bottom: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
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
            padding: 10px 12px;
            color: #e8e8e8;
            font-size: 0.9rem;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #f5c518;
        }

        .btn-row {
            display: flex;
            gap: 12px;
        }

        button[type="submit"] {
            background: #f5c518;
            color: #0d0d0d;
            border: none;
            border-radius: 4px;
            padding: 11px 28px;
            font-size: 0.85rem;
            font-weight: bold;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover { background: #e6b800; }

        .btn-clear {
            background: transparent;
            color: #888;
            border: 1px solid #333;
            border-radius: 4px;
            padding: 11px 22px;
            font-size: 0.85rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: border-color 0.2s, color 0.2s;
        }
        .btn-clear:hover { border-color: #888; color: #e8e8e8; }

        /* Results */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 16px;
        }

        .results-title {
            font-size: 1rem;
            color: #aaa;
            letter-spacing: 0.05em;
        }

        .results-count {
            font-size: 0.8rem;
            color: #f5c518;
            letter-spacing: 0.1em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            padding: 12px 14px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #666;
            border-bottom: 1px solid #2a2a2a;
        }

        tbody tr {
            border-bottom: 1px solid #1e1e1e;
            transition: background 0.15s;
        }

        tbody tr:hover { background: #161616; }

        tbody td {
            padding: 13px 14px;
            font-size: 0.9rem;
            color: #ccc;
        }

        .rating-badge {
            display: inline-block;
            background: #1f1f00;
            color: #f5c518;
            border-radius: 3px;
            padding: 2px 8px;
            font-size: 0.82rem;
            font-weight: bold;
        }

        .watched-yes { color: #4caf80; }
        .watched-no  { color: #888; }

        .no-results {
            text-align: center;
            padding: 50px 20px;
            color: #555;
            font-size: 0.9rem;
            letter-spacing: 0.08em;
        }

        .hint {
            margin-top: 10px;
            font-size: 0.78rem;
            color: #444;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>
<div class="container">

    <a class="back-link" href="BrennanIndex.php">← Back to Index</a>

    <h1>Search Movies</h1>
    <p class="subtitle">Query the movies table — leave fields blank to return all results</p>

    <!-- Search Form -->
    <form class="search-form" method="GET" action="BrennanQuery.php">
        <div class="form-grid">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title"
                       placeholder="e.g. Inception"
                       value="<?php echo htmlspecialchars($_GET['title'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre"
                       placeholder="e.g. Sci-Fi"
                       value="<?php echo htmlspecialchars($_GET['genre'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="release_year">Release Year</label>
                <input type="number" id="release_year" name="release_year"
                       placeholder="e.g. 2010" min="1888" max="2099"
                       value="<?php echo htmlspecialchars($_GET['release_year'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="min_rating">Min Rating (0–10)</label>
                <input type="number" id="min_rating" name="min_rating"
                       placeholder="e.g. 8.5" min="0" max="10" step="0.1"
                       value="<?php echo htmlspecialchars($_GET['min_rating'] ?? ''); ?>">
            </div>
        </div>
        <div class="btn-row">
            <button type="submit" name="search">Search</button>
            <a class="btn-clear" href="BrennanQuery.php">Clear</a>
        </div>
    </form>

    <!-- Results -->
    <?php if ($searched): ?>
        <div class="results-header">
            <span class="results-title">Results</span>
            <span class="results-count"><?php echo $totalFound; ?> movie<?php echo $totalFound !== 1 ? 's' : ''; ?> found</span>
        </div>

        <?php if ($totalFound > 0): ?>
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
                    <?php while ($row = $results->fetch_assoc()): ?>
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
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-results">
                No movies matched your search.
                <p class="hint">Try broadening your criteria or clearing the form.</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
</body>
</html>