<?php
session_start();
$host = 'localhost'; // Your database host
$db = 'your_database'; // Your database name
$user = 'your_username'; // Your database username
$pass = 'your_password'; // Your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $message = "Username already taken";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    <?php if ($message != ''): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="signup.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
