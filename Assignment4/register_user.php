
<?php
session_start();

require_once 'database.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit();
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || strlen($password) < 8) {
    exit('Please enter a username, valid email, and password of at least 8 characters.');
}

try {
    $query = 'SELECT userID FROM users
              WHERE username = :username OR email = :email';
    $statement = $db->prepare($query);
    $statement->execute([
        ':username' => $username,
        ':email' => $email
    ]);

    if ($statement->fetch()) {
        exit('Username or email already exists.');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = 'INSERT INTO users (username, email, password)
              VALUES (:username, :email, :password)';
    $statement = $db->prepare($query);
    $statement->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword
    ]);

    session_regenerate_id(true);
    $_SESSION['userID'] = $db->lastInsertId();
    $_SESSION['username'] = $username;

    header('Location: register_confirmation.php');
    exit();

} catch (PDOException $e) {
    error_log($e->getMessage());
    exit('Registration failed. Please try again.');
}
