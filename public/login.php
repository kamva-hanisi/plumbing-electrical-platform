<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/bootstrap.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (!verifyCsrf()) {
        $error = 'Invalid request. Please refresh the page.';
    } elseif ($email === '' || $password === '') {
        $error = 'Enter your email address and password.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT id, email, password_hash, role, status
             FROM users
             WHERE email = :email
             LIMIT 1'
        );

        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        if (
            $user &&
            $user['status'] === 'ACTIVE' &&
            password_verify($password, $user['password_hash'])
        ) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['user_role'] = $user['role'];

            unset($_SESSION['csrf_token']);

            header('Location: index.php');
            exit;
        }

        $error = 'Invalid email address or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Plumbing & Electrical</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <a href="index.php" class="logo">
            <span class="logo-mark">P</span>
            PLUMB<span class="accent">&</span>ELEC
        </a>

        <h1>Welcome back</h1>

        <p class="auth-description">
            Log in to access your account.
        </p>

        <?php if ($error): ?>
            <div class="error-message">
                <?= escape($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <input type="hidden" name="csrf_token"
                value="<?= escape(csrfToken()) ?>">

            <label>Email Address</label>
            <input type="email" name="email"
                value="<?= escape($email) ?>" required>

            <label>Password</label>
            <input type="password" name="password"
                autocomplete="current-password" required>

            <button type="submit" class="button button-primary auth-submit">
                Log In
            </button>

        </form>

        <p class="auth-footer">
            Don't have an account?
            <a href="register.php">Create account</a>
        </p>

    </div>

</body>

</html>