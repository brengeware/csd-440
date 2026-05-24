<?php
/* BrennanJSON.php
CSD440 - Assignment 10.2
5/24/26
A form that collects user info and displays it in JSON format.
*/

$error = "";
$jsonOutput = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["email"]) || 
        empty($_POST["phone"]) || empty($_POST["birthday"]) || empty($_POST["city"]) || 
        empty($_POST["state"]) || empty($_POST["occupation"]) || empty($_POST["experience"]) ||
        empty($_POST["bio"])) {

        $error = "All fields are required.";
    } else {

    //store form data in an array
    $data = array(
        "first_name" => $_POST["first_name"],
        "last_name" => $_POST["last_name"],
        "email" => $_POST["email"],
        "phone" => $_POST["phone"],
        "birthday" => $_POST["birthday"],
        "city" => $_POST["city"],
        "state" => $_POST["state"],
        "occupation" => $_POST["occupation"],
        "experience" => $_POST["experience"],
        "bio" => $_POST["bio"]
    );

    //encode the array as JSON
    $jsonOutput = json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrennanJSON</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        input, textarea {
            width: 100%;
            padding: 6px;
            margin-bottom: 12px;
        }
        input[type="submit"] {
            width: auto;
            padding: 8px 20px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 12px;
        }
        pre {
            background: #f4f4f4;
            padding: 16px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h2>User Info Form</h2>

<?php if ($error != ""): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($jsonOutput != ""): ?>
    <h4>I was joking about storing your data. But hey check out the JSON!</h4>
    <h3>JSON Output:</h3>
    <pre><?php echo htmlspecialchars($jsonOutput); ?></pre>
<?php else: ?>
    <h4>Your precious personal information will be displayed in JSON! And stored on my server! Yay!</h4>

<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

<label>First Name:</label>
<input type="text" name="first_name">

<label>Last Name:</label>
<input type="text" name="last_name">

<label>Email:</label>
<input type="email" name="email">

<label>Phone Number:</label>
<input type="text" name="phone">

<label>Birthday:</label>
<input type="date" name="birthday">

<label>City:</label>
<input type="text" name="city">

<label>State:</label>
<input type="text" name="state">

<label>Occupation:</label>
<input type="text" name="occupation">

<label>Experience Level:</label>
<input type="text" name="experience">

<label>Bio:</label>
<textarea name="bio" rows="4"></textarea>

<input type="submit" value="Submit">
</form>

<?php endif; ?>

</body>
</html>
