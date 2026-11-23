<?php

declare(strict_types=1);

date_default_timezone_set('Africa/Johannesburg');

$pageTitle = 'Plumbing & Electrical Services Platform';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

    <meta name="description" content="Plumbing and electrical services platform serving Gauteng, South Africa.">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <header class="header">
        <div class="container">
            <a href="index.php" class="logo">
                Plumbing & Electrical
            </a>

            <span class="environment-label">Development Environment</span>
        </div>
    </header>

    <main class="main">
        <section class="hero container">

            <span class="eyebrow">PROJECT INITIALIZATION</span>

            <h1>
                Our platform starts here.
            </h1>

            <p>
                A digital platform connecting customers with
                professional plumbing and electrical services
                across Gauteng, South Africa.
            </p>

            <div class="status-card">
                <span class="status-indicator"></span>

                <div>
                    <strong>PHP is working!</strong>
                    <small>
                        Server time:
                        <?= date('d M Y, H:i:s') ?>
                    </small>
                </div>
            </div>

            <button id="testButton" class="primary-button">
                Test JavaScript
            </button>

            <p id="testMessage" class="test-message">
                JavaScript test has not been performed.
            </p>

        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>
                &copy; <?= date('Y') ?> Plumbing & Electrical
                Services Platform.
            </p>
            <p>Development Version 1.0</p>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>

</body>
</html>
