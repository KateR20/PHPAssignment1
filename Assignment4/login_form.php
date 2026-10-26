
<?php
session_start();

if (isset($_SESSION['userID'])) {
    header('Location: login_confirmation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Contact Manager</title>


</head>
<body>
    <h1>Login to Contact Manager</h1>


    <?php
    if (isset($_SESSION['login_error'])) {
        echo '<p style="color: red;">' .
            htmlspecialchars($_SESSION['login_error'], ENT_QUOTES, 'UTF-8') .
            '</p>';

        unset($_SESSION['login_error']);
    }
    ?>

    <form action="login.php" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account?
        <a href="register.php">Register here</a>
    </p>
</body>
</html>
