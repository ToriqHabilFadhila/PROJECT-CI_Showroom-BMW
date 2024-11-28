<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: url('<?= base_url("assets/images/Background.jpg") ?>') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333333;
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

        .login-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
            width: 430px;
        }

        .login-form h2 {
            margin-bottom: 30px;
            font-weight: 600;
            color: #0056b3;
            text-align: center;
        }

        .login-form img {
            max-width: 60%;
            height: auto;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid #d1d5db;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }

        .input-group-text {
            border-radius: 25px;
            border: 1px solid #d1d5db;
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .btn-primary {
            border-radius: 25px;
            background-color: #0056b3;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #003d80;
        }

        .text-center p {
            margin-top: 20px;
            color: #6c757d;
        }

        .alert {
            border-radius: 25px;
        }

        .password-toggle {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <img src="<?= base_url('assets/images/LOGO.png') ?>" alt="Showroom BMW" class="img-fluid">
        <form action="/loginSubmit" method="post" id="loginForm">
            <?= csrf_field() ?>
            <h2>Login</h2>
            <?php if (session()->getFlashdata('msg')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" required aria-label="Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password Anda" required aria-label="Password">
                    <div class="input-group-append">
                        <span class="input-group-text password-toggle" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <div class="text-center">
                <p>Belum punya akun? <a href="/register" class="text-primary">Registrasi di sini</a></p>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.getElementById("loginForm").addEventListener("submit", function(event) {
            const email = document.querySelector("input[name='email']").value;
            const password = document.querySelector("input[name='password']").value;

            if (!email || !password) {
                event.preventDefault();
                alert("Email dan Password harus diisi!");
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>