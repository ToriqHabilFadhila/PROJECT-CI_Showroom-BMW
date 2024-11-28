<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <style>
        :root {
            --bmw-blue: #003366;
            --bmw-dark: #002244;
            --header-height: 85px;
            --transition-speed: 0.3s;

            --gap-top: 20px;
            --gap-right: 15px;
            --gap-bottom: 20px;
            --gap-left: 15px;
        }

        body {
            background: url('<?= base_url("assets/images/Background.jpg") ?>') no-repeat center center fixed;
            background-size: cover; 
            background-attachment: fixed;
            background-position: center;
            background-blend-mode: overlay;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            transition: padding-top var(--transition-speed) ease;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit; 
            filter: blur(5px);
            z-index: -1;
        }

        body.header-hidden .header-container {
            transform: translateY(-100%); 
            transition: transform var(--transition-speed) ease;
            will-change: transform;
        }

        body.header-hidden .main-content {
            padding-top: 0;
            transition: padding-top var(--transition-speed) ease;
            will-change: padding-top;
        }

        .main-content {
            transition: padding-top var(--transition-speed) ease; 
            padding-top: calc(var(--header-height) + 85px);
        }

        .container {
            border-radius: 12px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7));
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
            margin-bottom: 15px;
        }

        h1 {
            color: var(--bmw-blue);
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-secondary {
            margin: 5px;
            font-weight: 500;
            background-color: var(--bmw-blue);
            color: white;
            border: none;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
        }

        .btn-secondary:hover {
            background-color: var(--bmw-dark);
            transform: scale(1.05);
        }

        img.img-fluid {
            max-width: 40%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            cursor: pointer; 
        }

        img.img-fluid:hover {
            transform: scale(1.05); 
            filter: brightness(1.1);
        }

        img.img-fluid:active {
            transform: scale(0.98) rotate(-5deg);
        }

        img.img-fluid:focus {
            outline: none;
            box-shadow: 0 0 8px 3px rgba(0, 51, 102, 0.6);
        }

        .navbar {
            padding: 5px 0;
            background-color: transparent !important;
            border-bottom: 3px solid var(--bmw-dark);
            transition: background-color var(--transition-speed) ease;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            color: var(--bmw-blue);
            text-transform: uppercase;
            font-size: 1.25rem;
            gap: 15px;
            transition: color var(--transition-speed) ease;
        }

        .navbar-brand img {
            max-height: 70px;
            border-radius: 5px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, filter 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .navbar-brand img:active {
            transform: scale(0.98) rotate(-5deg);
        }

        .navbar-brand:hover {
            color: var(--bmw-dark);
        }

        .nav-link {
            font-weight: 600;
            color: var(--bmw-blue);
            margin: 0 15px;
            padding: 10px 20px;
            border-radius: 20px; 
            position: relative; 
            transition: all 0.3s ease;
            display: inline-block;
            text-transform: uppercase; 
            letter-spacing: 1px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 10%;
            width: 80%;
            height: 2px;
            background-color: var(--bmw-dark); 
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover {
            color: var(--bmw-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            background-color: rgba(0, 51, 102, 0.1);
            text-decoration: none; 
        }

        .nav-link:hover::before {
            transform: scaleX(1); 
        }

        .nav-link:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            color: var(--bmw-dark); 
        }

        .nav-link:focus {
            outline: none;
            box-shadow: 0 0 5px 3px rgba(0, 51, 102, 0.6);
        }

        footer {
            padding: 20px 0;
            font-size: 1rem;
            border-top: 3px solid var(--bmw-dark);
            background: linear-gradient(145deg, rgba(255, 255, 255, 1), rgba(240, 240, 240, 0.7));
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 30px;
            transition: box-shadow 0.3s ease-in-out;
        }

        footer p {
            color: var(--bmw-blue); 
            margin: 0;
            font-weight: 500; 
            transition: color 0.3s ease; 
        }

        .header-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1001;
            background: var(--bmw-blue);
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .header-toggle:hover {
            background: white;
            color: var(--bmw-blue);
            transform: rotate(180deg);
        }

        .header-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: transform var(--transition-speed) ease-in-out;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(28, 28, 28, 0.98);
                margin: 15px -15px -20px;
                padding: 15px;
                border-radius: 0 0 15px 15px;
            }

            .nav-link {
                margin: 5px 0;
                text-align: center;
            }

            .navbar-toggler {
                background: white !important;
                padding: 8px;
            }

            .navbar-toggler i {
                color: var(--bmw-dark);
            }
        }
    </style>
</head>
<body class="header-hidden">
    <button class="header-toggle" onclick="toggleHeader()" title="Toggle Header">
        <i class="fas fa-chevron-down"></i>
    </button>

    <div class="header-container">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url('assets/images/LOGO.png') ?>" alt="BMW Logo">
                    <span>BMW Showroom</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="background: white; padding: 8px;">
                    <i class="fas fa-bars" style="color: var(--bmw-dark);"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">
                                <i class="fas fa-home"></i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <main class="main-content">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleHeader() {
            document.body.classList.toggle('header-hidden');
            const icon = document.querySelector('.header-toggle i');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isLoggedIn = <?= isset($_SESSION['logged_in']) ? 'true' : 'false' ?>;
            if (!isLoggedIn) {
                document.body.classList.add('header-hidden');
            }

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>