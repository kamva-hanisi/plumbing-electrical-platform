<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/bootstrap.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors = [];

$firstName = '';
$lastName = '';
$email = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrf()) {
        $errors[] = 'Invalid request. Please refresh the page.';
    }

    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($firstName === '' || $lastName === '') {
        $errors[] = 'Enter your first and last name.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    if (strlen($password) < 12) {
        $errors[] = 'Password must contain at least 12 characters.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if ($phone === '') {
        $errors[] = 'Enter your phone number.';
    }

    if (!$errors) {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare(
                'INSERT INTO users (email, password_hash, role)
                 VALUES (:email, :password_hash, :role)'
            );

            $stmt->execute([
                'email' => $email,
                'password_hash' => password_hash(
                    $password,
                    PASSWORD_DEFAULT
                ),
                'role' => 'CUSTOMER'
            ]);

            $userId = (int) $pdo->lastInsertId();

            $stmt = $pdo->prepare(
                'INSERT INTO customer_profiles
                 (user_id, first_name, last_name, phone)
                 VALUES (:user_id, :first_name, :last_name, :phone)'
            );

            $stmt->execute([
                'user_id' => $userId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone
            ]);

            $pdo->commit();

            session_regenerate_id(true);

            $_SESSION['user_id'] = $userId;
            $_SESSION['user_role'] = 'CUSTOMER';

            unset($_SESSION['csrf_token']);

            header('Location: index.php');
            exit;
        } catch (PDOException $exception) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            if ($exception->getCode() === '23000') {
                $errors[] = 'This email address is already registered.';
            } else {
                error_log($exception->getMessage());
                $errors[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Plumbing & Electrical</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <a href="index.php" class="logo">
            <span class="logo-mark">P</span>
            PLUMB<span class="accent">&</span>ELEC
        </a>

        <h1>Create your account</h1>
        <p class="auth-description">
            Register to request services and manage your bookings.
        </p>

        <?php foreach ($errors as $error): ?>
            <div class="error-message">
                <?= escape($error) ?>
            </div>
        <?php endforeach; ?>

        <form method="POST">

            <input type="hidden" name="csrf_token"
                value="<?= escape(csrfToken()) ?>">

            <label>First Name</label>
            <input type="text" name="first_name"
                value="<?= escape($firstName) ?>" required>

            <label>Last Name</label>
            <input type="text" name="last_name"
                value="<?= escape($lastName) ?>" required>

            <label>Email Address</label>
            <input type="email" name="email"
                value="<?= escape($email) ?>" required>

            <label>Phone Number</label>
            <input type="tel" name="phone"
                value="<?= escape($phone) ?>" required>

            <label>Password</label>
            <input type="password" name="password"
                minlength="12" autocomplete="new-password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password"
                minlength="12" autocomplete="new-password" required>

            <button type="submit" class="button button-primary auth-submit">
                Create Account
            </button>

        </form>

        <p class="auth-footer">
            Already registered?
            <a href="login.php">Log in</a>
        </p>

    </div>

</body>

</html>