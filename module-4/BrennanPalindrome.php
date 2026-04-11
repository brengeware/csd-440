<!DOCTYPE html>
<html>
    <head>
        <title>Palindrome Checker 1.0</title>
    </head>
    <body>

    <?php
    /*
    Brennan Cheatwood
    CSD440 - Assignment 4.2
    4/11/26

    Palindrome Checker Program
    This program will check if a string is a palindrome.
    It shows six examples, three that are palindromes &
    three that aren't. It displays the string forwards and backwards
    and tells you the result.

    */

    //This function takes a string and checks if it's a palindrome
    //It will return true if it is, and false if not
    function isPalindrome($str) {
        //first, convert everything to lowercase so the check isn't case sensitive
        $str = strtolower($str);

        //then, reverse the string
        $reversed = strrev($str);

        //if the string = the reversed version, it's a palindrome
        if ($str == $reversed) {
            return true;
        } else {
            return false;
        }
    }

    //this function displays the string forward, backward, adn result
    function displayResult($str) {
        $reversed = strrev(strtolower($str));
        $original = strtolower($str);

        echo "<p>";
        echo "<strong>Original:</strong> " . $original . "<br>";
        echo "<strong>Reversed:</strong> " . $reversed . "<br>";

        //call isPalindrome to get result & display it
        if (isPalindrome($str)) {
            echo "<strong>Result:</strong> \"" . $original . "\" IS a palindrome!";
        } else {
            echo "<strong>Result:</strong> \"" . $original . "\" is NOT a palindrome.";
        }

        echo "</p>";
        echo "<hr>";
    }

    // \/ \/ \/ main program \/ \/ \/

    echo "<h1>Palindrome Checker v1.0</h1>";
    echo "<p>This program checks if a word or phrase is a palindrome (reads the same forwards & backwards).</p>";
    echo "<hr>";

    //palindromes
    echo "<h2>Palindrome Examples</h2>";
    displayResult("racecar");
    displayResult("madam");
    displayResult("level");

    //non-palindromes
    echo "<h2>Non-Palindrome Examples</h2>";
    displayResult("howdy");
    displayResult("samsung");
    displayResult("bruins");

    ?>

    </body>
    </html>





    </body>
</html>