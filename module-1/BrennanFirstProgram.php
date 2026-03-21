<?php
/*
File Name: BrennanFirstProgram.php
Author: Brennan Cheatwood
Course: CSD440 - Server Side Scripting
Desc: This program demos a simple PHP page with
standard HTML tags and multiple PHP code snippets.
Date: 3/21/26
*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My First PHP Program</title>
    </head>
    <body>

        <h1>My First PHP Program</h1>
        <p>This page is being displayed using PHP in XAMPP.</p>

        <?php
        // PHP code snippet 1
        $studentName = "Brennan";
        echo "<p>Hello, my name is " . $studentName .".</p>";
        ?>

        <?php
        //Snippet 2
        $number1 = 10;
        $number2 = 15;
        $total = $number1 + $number2;

        echo "<p>The sum of $number1 and $number2 is $total.</p>";
        ?>

        <p>This confirms that PHP is working correctly on my computer</p>
    </body>
    </html>