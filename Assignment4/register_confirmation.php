
<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header('Location: register.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
</head>
<body>
    <h1>Registration Successful!</h1>

    <p>Welcome, <?php echo $username; ?>!</p>

    <p>Your account has been created successfully.</p>

    <a href="index.php">Go to Contact Manager</a>
</body>
</html>
