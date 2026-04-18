<?php
/**
 * Brennan Cheatwood
 * CSD440 - Assignment 5.2
 * 4/18/26
 * This program creates an array of customers
 * that includes their first name, last name
 * and phone number. I then use PHP array methods
 * to search through the list and display results 
 * based on different fields like last name, age and area code.
 * 
 */



//Array of customers. Each customer is stored as an 
//associative array with 4 fields: first name, last name, age, and phone #
$customers = [
    ["first" => "Alice", "last" => "Johnson", "age" => 34, "phone" => "865-555-0101"],
    ["first" => "Bob", "last" => "Martinez", "age" => 27, "phone" => "865-555-0102"],
    ["first" => "Carol",   "last" => "Thompson",  "age" => 45, "phone" => "865-555-0103"],
    ["first" => "David",   "last" => "Lee",       "age" => 31, "phone" => "865-555-0104"],
    ["first" => "Emma",    "last" => "Wilson",    "age" => 52, "phone" => "865-555-0105"],
    ["first" => "Frank",   "last" => "Garcia",    "age" => 29, "phone" => "865-555-0106"],
    ["first" => "Grace",   "last" => "Anderson",  "age" => 40, "phone" => "865-555-0107"],
    ["first" => "Henry",   "last" => "Taylor",    "age" => 23, "phone" => "865-555-0108"],
    ["first" => "Isabel",  "last" => "Thomas",    "age" => 36, "phone" => "865-555-0109"],
    ["first" => "James",   "last" => "Johnson",   "age" => 61, "phone" => "865-555-0110"],
    ["first" => "Karen",   "last" => "White",     "age" => 48, "phone" => "865-555-0111"],
    ["first" => "Liam",    "last" => "Harris",    "age" => 19, "phone" => "865-555-0112"],
];

//renderRow()

function renderRow(array $c): string {

    return sprintf(
        "<tr><td>%s</td><td>%s</td><td>%d</td><td>%s</td></tr>\n",
        htmlspecialchars($c["first"]),
        htmlspecialchars($c["last"]),
        (int)$c["age"],
        htmlspecialchars($c["phone"]),
    );
}

//renderTable()

function renderTable(string $title, array $rows): string {
    $html  = "<section>\n";
    $html .= "  <h2>" . htmlspecialchars($title) . "</h2>\n";
 
    //Check if we actually got any results before building the table
    if (empty($rows)) {
        $html .= "  <p class='empty'>No matching customers found.</p>\n";
    } else {
        $html .= "  <table>\n";
        $html .= "    <thead><tr><th>First Name</th><th>Last Name</th><th>Age</th><th>Phone</th></tr></thead>\n";
        $html .= "    <tbody>\n";
        // Loop through each customer and add a row
        foreach ($rows as $c) {
            $html .= "    " . renderRow($c);
        }
        $html .= "    </tbody>\n";
        $html .= "  </table>\n";
        //Show how many records were returned at the bottom
        $html .= "  <p class='count'>Records found: " . count($rows) . "</p>\n";
    }
 
    $html .= "</section>\n";
    return $html;
}

// -------------------------------------------------------------------
// SEARCHES - Here I'm using different PHP array methods to find
// specific customer records based on different data fields.
// -------------------------------------------------------------------
 
/**
 * Search 1 - Find customers by last name using array_filter()
 * I'm using strcasecmp() so the search isn't case-sensitive.
 */
$lastNameSearch = "Johnson";
$byLastName = array_values(array_filter($customers, function($c) use ($lastNameSearch) {
    return strcasecmp($c["last"], $lastNameSearch) === 0;
}));
 
/**
 * Search 2 - Find customers who are 40 or older using array_filter()
 * This could be useful for things like targeted marketing by age group.
 */
$minAge = 40;
$byMinAge = array_values(array_filter($customers, function($c) use ($minAge) {
    return $c["age"] >= $minAge;
}));
 
/**
 * Search 3 - Find customers under the age of 30 using array_filter()
 * Just the opposite of search 2, looking at the younger customers.
 */
$byUnder30 = array_values(array_filter($customers, function($c) {
    return $c["age"] < 30;
}));
 
/**
 * Search 4 - Find customers with a specific area code using array_filter()
 * I'm using strpos() to check if the phone number starts with "865".
 * strpos() returns 0 if the match is at the very beginning of the string.
 */
$areaCode = "865";
$byAreaCode = array_values(array_filter($customers, function($c) use ($areaCode) {
    return strpos($c["phone"], $areaCode) === 0;
}));
 
/**
 * Search 5 - Find the 3 youngest customers using usort() and array_slice()
 * I copy the array first so I don't mess up the original, then sort it
 * by age from lowest to highest, and grab just the first 3 results.
 */
$sorted = $customers; // copy so the original stays in order
usort($sorted, fn($a, $b) => $a["age"] - $b["age"]);
$threeYoungest = array_slice($sorted, 0, 3);
 
/**
 * Search 6 - Find the oldest customer using usort() descending
 * Same idea as search 5 but sorted the other way so the oldest is first.
 */
$sortedDesc = $customers;
usort($sortedDesc, fn($a, $b) => $b["age"] - $a["age"]);
$oldestCustomer = [$sortedDesc[0]];
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brennan Customers</title>
    <style>
        /* Basic reset so everything looks consistent across browsers */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
        body {
            font-family: 'Helvetica', serif;
            background: #0d1117;
            color: #e6edf3;
            padding: 2rem 1.5rem 4rem;
            min-height: 100vh;
        }
 
        /* Page header styles */
        header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        header h1 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            letter-spacing: .04em;
            color: #58a6ff;
            text-transform: uppercase;
        }
        header p {
            margin-top: .4rem;
            font-size: .9rem;
            color: #8b949e;
        }
 
        /* Each search result gets its own card-style section */
        section {
            max-width: 860px;
            margin: 0 auto 2.5rem;
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 8px;
            padding: 1.5rem;
        }
        section h2 {
            font-size: 1.05rem;
            color: #58a6ff;
            margin-bottom: 1rem;
            padding-bottom: .5rem;
            border-bottom: 1px solid #30363d;
            letter-spacing: .03em;
        }
 
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .92rem;
        }
        thead tr { background: #21262d; }
        thead th {
            padding: .55rem .9rem;
            text-align: left;
            color: #8b949e;
            font-weight: 600;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        tbody tr { border-top: 1px solid #21262d; }
        tbody tr:hover { background: #1c2128; }
        tbody td { padding: .55rem .9rem; }
 
        /* Record count shown below each table */
        p.count {
            margin-top: .85rem;
            font-size: .8rem;
            color: #8b949e;
            text-align: right;
        }
        p.empty { color: #f85149; font-size: .9rem; }
 
        /* Footer at the bottom */
        footer {
            text-align: center;
            font-size: .78rem;
            color: #484f58;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
 
<header>
    <h1>Brennan's Customer List</h1>
    <p>CSD440 &mdash; Server-Side Scripting &mdash; PHP Array Methods Assignment</p>
</header>
 
<main>
 
    <?php
    // Display the full customer list first
    echo renderTable("All Customers (Full List)", $customers);
 
    // Search 1: Filter by last name
    echo renderTable(
        "Customers with Last Name \"{$lastNameSearch}\" — array_filter() + strcasecmp()",
        $byLastName
    );
 
    // Search 2: Customers age 40 and older
    echo renderTable(
        "Customers Age {$minAge} and Older — array_filter()",
        $byMinAge
    );
 
    // Search 3: Customers under 30
    echo renderTable(
        "Customers Under Age 30 — array_filter()",
        $byUnder30
    );
 
    // Search 4: Customers by area code
    echo renderTable(
        "Customers with Area Code \"{$areaCode}\" — array_filter() + strpos()",
        $byAreaCode
    );
 
    // Search 5: 3 youngest customers
    echo renderTable(
        "3 Youngest Customers — usort() + array_slice()",
        $threeYoungest
    );
 
    // Search 6: Oldest customer
    echo renderTable(
        "Oldest Customer — usort() Descending",
        $oldestCustomer
    );
    ?>
 
</main>
 
<footer>
    <p>Brennan_Customers.php &mdash; Brennan Cheatwood &mdash; CSD440 Server-Side Scripting &mdash; 2026-04-18</p>
</footer>
 
</body>
</html>