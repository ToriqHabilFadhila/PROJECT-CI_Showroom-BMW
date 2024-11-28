<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
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

        .register-form {
            width: 100%;
            max-width: 460px;
            margin: 100px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
        }

        .register-form h2 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #0056b3;
            text-align: center;
        }

        .register-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-image img {
            max-width: 40%;
            height: auto;
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

        .btn-primary {
            background-color: #0056b3;
            border-color: #0056b3;
            border-radius: 25px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #003d80;
            border-color: #003d80;
        }

        .text-danger {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <div class="register-image">
            <img src="<?= base_url('assets/images/LOGO.png') ?>" class="img-fluid" alt="Showroom BMW">
        </div>
        <form action="/registerSubmit" method="post" id="registerForm">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= set_value('nama') ?>" required aria-label="Nama">
                <?php if(isset($validation) && $validation->hasError('nama')): ?>
                    <div class="text-danger">
                        <?= $validation->getError('nama') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" required aria-label="Email">
                <?php if(isset($validation) && $validation->hasError('email')): ?>
                    <div class="text-danger">
                        <?= $validation->getError('email') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required aria-label="Password">
                    <div class="input-group-append">
                        <span class="input-group-text password-toggle" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <?php if(isset($validation) && $validation->hasError('password')): ?>
                    <div class="text-danger">
                        <?= $validation->getError('password') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confpassword">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confpassword" name="confpassword" required aria-label="Konfirmasi Password">
                    <div class="input-group-append">
                        <span class="input-group-text password-toggle" id="toggleConfPassword">
                            <i class="fas fa-eye" id="confEyeIcon"></i>
                        </span>
                    </div>
                </div>
                <?php if(isset($validation) && $validation->hasError('confpassword')): ?>
                    <div class="text-danger">
                        <?= $validation->getError('confpassword') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= set_value('alamat') ?>" required aria-label="Alamat">
                <?php if(isset($validation) && $validation->hasError('alamat')): ?>
                    <div class="text-danger">
                        <?= $validation->getError('alamat') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="<?= set_value('telepon') ?>" required aria-label="Telepon">
                <?php if(isset($validation) && $validation->hasError('telepon')): ?>
                    <div class="text-danger">
                        <?= $validation->getError('telepon') ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>
        <div class="text-center mt-3">
            <p>Sudah punya akun? <a href="/login">Login di sini</a></p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').onclick = function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        document.getElementById('toggleConfPassword').onclick = function() {
            const confPasswordInput = document.getElementById('confpassword');
            const confEyeIcon = document.getElementById('confEyeIcon');
            if (confPasswordInput.type === "password") {
                confPasswordInput.type = "text";
                confEyeIcon.classList.remove('fa-eye');
                confEyeIcon.classList.add('fa-eye-slash');
            } else {
                confPasswordInput.type = "password";
                confEyeIcon.classList.remove('fa-eye-slash');
                confEyeIcon.classList.add('fa-eye');
            }
        }

        document.getElementById("registerForm").addEventListener("submit", function(event) {
            const password = document.getElementById('password').value;
            const confPassword = document.getElementById('confpassword').value;

            if (password !== confPassword) {
                event.preventDefault(); 
                alert("Password dan Konfirmasi Password tidak cocok!");
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>