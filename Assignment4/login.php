
<?php
session_start();

require_once 'database.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login_form.php');
    exit();
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$query = 'SELECT * FROM users WHERE username = :username';
$statement = $db->prepare($query);
$statement->execute([':username' => $username]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['login_error'] = 'Invalid username or password.';
    header('Location: login_form.php');
    exit();
}


// Check whether the account is locked
$query = 'SELECT locked_until > NOW() AS is_locked
          FROM users
          WHERE userID = :userID';

$statement = $db->prepare($query);
$statement->execute([':userID' => $user['userID']]);

$isLocked = (int) $statement->fetchColumn();

if ($isLocked === 1) {
    $_SESSION['login_error'] =
        'Account locked. Please try again later.';

    header('Location: login_form.php');
    exit();
}


// Verify the password
if (password_verify($password, $user['password'])) {
    $query = 'UPDATE users
              SET failed_attempts = 0, locked_until = NULL
              WHERE userID = :userID';
    $statement = $db->prepare($query);
    $statement->execute([':userID' => $user['userID']]);

    session_regenerate_id(true);
    $_SESSION['userID'] = $user['userID'];
    $_SESSION['username'] = $user['username'];

    header('Location: login_confirmation.php');
    exit();
}

// Handle incorrect passwords
$attempts = $user['failed_attempts'] + 1;

if ($attempts >= 3) {
    $query = 'UPDATE users
              SET failed_attempts = 3,
                  locked_until = DATE_ADD(NOW(), INTERVAL 15 MINUTE)
              WHERE userID = :userID';
} else {
    $query = 'UPDATE users
              SET failed_attempts = :attempts
              WHERE userID = :userID';
}

$statement = $db->prepare($query);
$statement->bindValue(':userID', $user['userID']);

if ($attempts < 3) {
    $statement->bindValue(':attempts', $attempts, PDO::PARAM_INT);
}

$statement->execute();

$_SESSION['login_error'] = $attempts >= 3
    ? 'Account locked for 15 minutes.'
    : 'Invalid username or password.';

header('Location: login_form.php');
exit();
