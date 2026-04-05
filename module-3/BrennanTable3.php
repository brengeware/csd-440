<!DOCTYPE html>
<!--
    Filename:    BrennanTable3.php
    Author:      Brennan Cheatwood
    Course:      CSD440
    Assignment:  3.2
    Date:        <?php echo date("Y-m-d"); ?>
    Description: Builds on BrennanTable2.php by using an external function
                 to generate each cell value. Two random numbers are passed
                 into addNumbers() from brennan_functions.php, and their
                 sum is displayed in each table cell via a nested loop.
                 
-->

<?php
    // Include the external functions file
    require_once("brennan_functions.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brennan's Sum Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f2f2f2;
        }

        h1 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        th {
            background-color: #4a90d9;
            color: white;
            padding: 10px 20px;
            border: 1px solid #ccc;
        }

        td {
            text-align: center;
            padding: 10px 20px;
            border: 1px solid #ccc;
        }

        tr:nth-child(even) {
            background-color: #e8f0fb;
        }
    </style>
</head>
<body>

    <h1>Random Number Sum Table</h1>
    <p>
        Each cell displays the sum of two randomly generated numbers (1–50),
        calculated using the <strong>addNumbers()</strong> function from
        <em>brennan_functions.php</em>.
    </p>

    <table>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
            <th>Column 4</th>
            <th>Column 5</th>
        </tr>

        <?php
            // Outer loop controls the rows
            for ($row = 0; $row < 5; $row++):
        ?>
        <tr>
            <?php
                // Inner loop controls the columns
                for ($col = 0; $col < 5; $col++):

                    // Generate two random numbers to pass into the function
                    $num1 = rand(1, 50);
                    $num2 = rand(1, 50);

                    // Call external function to get the sum
                    $cellValue = addNumbers($num1, $num2);
            ?>
            <td><?php echo $cellValue; ?></td>
            <?php
                endfor; // end column loop
            ?>
        </tr>
        <?php
            endfor; // end row loop
        ?>

    </table>

</body>
</html>