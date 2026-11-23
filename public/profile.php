<?php
require_once __DIR__ . '/../app/config/bootstrap.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$errors = [];
$success = '';

$stmt = $pdo->prepare("
    SELECT u.email, cp.first_name, cp.last_name, cp.phone
    FROM users u
    INNER JOIN customer_profiles cp ON cp.user_id = u.id
    WHERE u.id = :user_id
");
$stmt->execute(['user_id' => $userId]);
$profile = $stmt->fetch();

if (!$profile) {
    http_response_code(404);
    exit('Customer profile not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if ($firstName === '' || $lastName === '' || $phone === '') {
            $errors[] = 'Please complete all required fields.';
        }

        if (!$errors) {
            $update = $pdo->prepare("
                UPDATE customer_profiles
                SET first_name = :first_name,
                    last_name = :last_name,
                    phone = :phone
                WHERE user_id = :user_id
            ");

            $update->execute([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone,
                'user_id' => $userId
            ]);

            $profile['first_name'] = $firstName;
            $profile['last_name'] = $lastName;
            $profile['phone'] = $phone;
            $success = 'Your profile has been updated.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Plumbing & Electrical</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="auth-page">

    <main class="auth-card">
        <h1>My Profile</h1>
        <p class="auth-description">View and update your personal details.</p>

        <?php if ($success): ?>
            <p class="success-message">
                <?= escape($success) ?>
            </p>
        <?php endif; ?>

        <?php foreach ($errors as $error): ?>
            <p class="error-message"><?= escape($error) ?></p>
        <?php endforeach; ?>

        <form method="POST">
            <input type="hidden" name="csrf_token"
                value="<?= escape(csrfToken()) ?>">

            <label for="first_name">First name</label>
            <input id="first_name" name="first_name"
                value="<?= escape($profile['first_name']) ?>" required>

            <label for="last_name">Last name</label>
            <input id="last_name" name="last_name"
                value="<?= escape($profile['last_name']) ?>" required>

            <label for="email">Email address</label>
            <input id="email" type="email"
                value="<?= escape($profile['email']) ?>" disabled>

            <label for="phone">Phone number</label>
            <input id="phone" name="phone"
                value="<?= escape($profile['phone']) ?>" required>

            <button type="submit" class="auth-submit">
                Save Changes
            </button>
        </form>

        <p class="auth-footer">
            <a href="index.php">Return to homepage</a>
        </p>
    </main>

</body>

</html>