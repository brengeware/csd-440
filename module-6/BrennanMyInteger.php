<?php
/*
 * Brennan Cheatwood
 * CSD440 - Assignment 6.2
 * 4/26/26
 * This program defines a MyInteger class that stores a single
 * integer and provides methods to check if it's even, odd, or prime.
 * Two instances are created and all methods are tested below.
 */

class BrennanMyInteger {
    private int $value;

    public function __construct(int $num){
        $this->value = $num;
    }

    //Getter
    public function getValue(): int{
        return $this->value;
    }

    //Setter
    public function setValue(int $num): void {
        $this->value = $num;
    }

    //Returns true if the given int is even
    public function isEven(int $num): bool{
        return $num % 2 === 0;
    }

    //returns true if the given int is odd
    public function isOdd(int $num): bool {
        return $num % 2 !== 0;
    }

    //Checks if the stored integer is a prime number
    //*numbers less than 2 are not prime*
    public function isPrime(): bool{
        $num = $this->value;

        if ($num < 2) {
            return false;
        }

        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i === 0) {
                return false;
            }
        }

        return true;
    }
}

//helper to display true/false as readable string
function boolToStr(bool $val): string{
    return $val ? "Yes" : "No";
}

//Two instances
$int1 = new BrennanMyInteger(14);
$int2 = new BrennanMyInteger(7);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrennanMyInteger</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            background-color: #f4f4f4;
            color: #333;
        }
 
        h1 {
            background-color: #4a90d9;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
        }
 
        h2 {
            color: #4a90d9;
            margin-top: 30px;
        }
 
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
 
        th, td {
            padding: 10px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
 
        th {
            background-color: #4a90d9;
            color: white;
        }
 
        tr:last-child td {
            border-bottom: none;
        }
 
        .setter-note {
            background-color: #fff8e1;
            border-left: 4px solid #f0b429;
            padding: 10px 16px;
            margin-top: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
 
    <h1>BrennanMyInteger - Test Output</h1>
 
    <!-- Instance 1 Testing -->
    <h2>Instance 1 &mdash; Value: <?php echo $int1->getValue(); ?></h2>
    <table>
        <tr>
            <th>Method</th>
            <th>Result</th>
        </tr>
        <tr>
            <td>getValue()</td>
            <td><?php echo $int1->getValue(); ?></td>
        </tr>
        <tr>
            <td>isEven(<?php echo $int1->getValue(); ?>)</td>
            <td><?php echo boolToStr($int1->isEven($int1->getValue())); ?></td>
        </tr>
        <tr>
            <td>isOdd(<?php echo $int1->getValue(); ?>)</td>
            <td><?php echo boolToStr($int1->isOdd($int1->getValue())); ?></td>
        </tr>
        <tr>
            <td>isPrime()</td>
            <td><?php echo boolToStr($int1->isPrime()); ?></td>
        </tr>
    </table>
 
    <!-- Instance 2 Testing -->
    <h2>Instance 2 &mdash; Value: <?php echo $int2->getValue(); ?></h2>
    <table>
        <tr>
            <th>Method</th>
            <th>Result</th>
        </tr>
        <tr>
            <td>getValue()</td>
            <td><?php echo $int2->getValue(); ?></td>
        </tr>
        <tr>
            <td>isEven(<?php echo $int2->getValue(); ?>)</td>
            <td><?php echo boolToStr($int2->isEven($int2->getValue())); ?></td>
        </tr>
        <tr>
            <td>isOdd(<?php echo $int2->getValue(); ?>)</td>
            <td><?php echo boolToStr($int2->isOdd($int2->getValue())); ?></td>
        </tr>
        <tr>
            <td>isPrime()</td>
            <td><?php echo boolToStr($int2->isPrime()); ?></td>
        </tr>
    </table>
 
    <!-- Setter test on Instance 1 -->
    <div class="setter-note">
        <?php
            $int1->setValue(13);
            echo "<strong>Setter test:</strong> Instance 1 value updated to " . $int1->getValue() . " using setValue(13).<br>";
            echo "isPrime() after update: " . boolToStr($int1->isPrime());
        ?>
    </div>
 
</body>
</html>