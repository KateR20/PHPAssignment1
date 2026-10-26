
<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header('Location: login_form.php');
    exit();
}

$username = htmlspecialchars(
    $_SESSION['username'],
    ENT_QUOTES,
    'UTF-8'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Successful</title>
</head>
<body>
    <h1>Login Successful!</h1>

    <p>Welcome back, <?php echo $username; ?>!</p>

    <p>You are now logged in to Contact Manager.</p>

    <a href="index.php">Go to Contact Manager</a>

<p>
    <a href="logout.php">Logout</a>
</p>

</body>
</html>
