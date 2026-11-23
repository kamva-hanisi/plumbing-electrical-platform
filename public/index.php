<?php

declare(strict_types=1);

date_default_timezone_set('Africa/Johannesburg');

$pageTitle = 'Plumbing & Electrical Services';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

    <meta name="description" content="Professional plumbing and electrical services across Gauteng.">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <header class="header">
        <div class="container navbar">
            <a href="index.php" class="logo">
                <span class="logo-mark">P</span>
                <span>PLUMB<span class="accent">&</span>ELEC</span>
            </a>

            <nav class="nav-links" id="navLinks">
                <a href="#home">Home</a>
                <a href="#services">Services</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
            </nav>

            <a href="#contact" class="nav-button">Get a Quote</a>

            <button class="menu-toggle" id="menuToggle" aria-label="Toggle navigation">
                ☰
            </button>
        </div>
    </header>

    <main>

        <section class="hero" id="home">
            <div class="container hero-content">

                <span class="eyebrow">PROFESSIONAL HOME SERVICES</span>

                <h1>
                    Reliable solutions.<br>
                    <span>Quality workmanship.</span>
                </h1>

                <p>
                    Professional plumbing and electrical services
                    for homes and businesses across Gauteng.
                </p>

                <div class="hero-actions">
                    <a href="#services" class="button button-primary">
                        Explore Services
                    </a>

                    <a href="#contact" class="button button-outline">
                        Request a Quote
                    </a>
                </div>

                <div class="hero-note">
                    <span class="status-dot"></span>
                    Serving customers across Gauteng, South Africa
                </div>

            </div>
        </section>

        <section class="services section" id="services">
            <div class="container">

                <div class="section-heading">
                    <span class="eyebrow">WHAT WE DO</span>
                    <h2>Our Services</h2>
                    <p>Practical solutions for your property.</p>
                </div>

                <div class="service-grid">

                    <article class="service-card">
                        <div class="service-icon">⌁</div>
                        <h3>Plumbing Services</h3>
                        <p>
                            Plumbing installations, repairs,
                            maintenance and leak solutions.
                        </p>
                        <a href="#contact">Explore plumbing <span>→</span></a>
                    </article>

                    <article class="service-card">
                        <div class="service-icon">ϟ</div>
                        <h3>Electrical Services</h3>
                        <p>
                            Electrical installations, repairs,
                            maintenance and fault finding.
                        </p>
                        <a href="#contact">Explore electrical <span>→</span></a>
                    </article>

                </div>
            </div>
        </section>

        <section class="about section" id="about">
            <div class="container about-content">
                <div>
                    <span class="eyebrow">OUR APPROACH</span>
                    <h2>Service made simple.</h2>
                </div>

                <p>
                    Our platform makes it easier to request services,
                    receive quotations and manage appointments.
                    Clear communication from request to completion.
                </p>
            </div>
        </section>

        <section class="contact section" id="contact">
            <div class="container contact-content">
                <div>
                    <span class="eyebrow">LET'S GET STARTED</span>
                    <h2>Need a service?</h2>
                    <p>Contact us to discuss your plumbing or electrical needs.</p>
                </div>

                <a href="mailto:info@example.com" class="button button-light">
                    Contact Us
                </a>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="container footer-content">
            <p>© <?= date('Y') ?> Plumbing & Electrical Services Platform.</p>
            <p>Gauteng, South Africa</p>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>

</body>

</html>