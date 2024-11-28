<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Tambah User</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('message')) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-4 rounded shadow-sm">
        <form id="userForm" action="/admin/storeUser" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="nama"><i class="fas fa-user"></i> Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                <small class="form-text text-muted">Nama lengkap pengguna.</small>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat email" required>
                <small class="form-text text-muted">Email harus valid.</small>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    <div class="input-group-append">
                        <span class="input-group-text password-toggle" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>
                <small class="form-text text-muted">Minimal 8 karakter, termasuk huruf dan angka.</small>
            </div>
            <div class="form-group">
                <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                <small class="form-text text-muted">Alamat lengkap pengguna.</small>
            </div>
            <div class="form-group">
                <label for="telepon"><i class="fas fa-phone"></i> Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon" required>
                <small class="form-text text-muted">Format: +621234567890.</small>
            </div>
            <div class="form-group">
                <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
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

    document.getElementById('userForm').addEventListener('submit', function (e) {
        const password = document.getElementById('password').value;
        const telepon = document.getElementById('telepon').value;

        if (password.length < 8) {
            e.preventDefault();
            alert('Password harus minimal 8 karakter!');
        }

        const phoneRegex = /^\+?[0-9]{8,14}$/;
        if (!phoneRegex.test(telepon)) {
            e.preventDefault();
            alert('Format nomor telepon tidak valid!');
        }
    });
</script>

<style>
    .container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 20px;
    }

    .bg-white {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .bg-white:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    h1 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 30px;
        position: relative;
    }

    h1:after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: #3498db;
        margin: 10px auto;
        border-radius: 2px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        color: #34495e;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    .form-group label i {
        margin-right: 8px;
        color: #3498db;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group .form-control {
        border-radius: 8px 0 0 8px;
        border-right: none;
        height: auto;
    }

    .input-group .password-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0 8px 8px 0;
        padding: 10px 15px;
        height: auto;
    }

    .input-group .password-toggle i {
        font-size: 1.3rem;
        color: #34495e;
    }

    .input-group .password-toggle:hover {
        background-color: #e9ecef;
        cursor: pointer;
    }

    .input-group-append {
        display: flex;
        align-items: center;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 8px 10px;
    }

    .password-toggle {
        cursor: pointer;
        background-color: #f8f9fa;
        border: 2px solid #e9ecef;
        border-left: none;
        transition: all 0.3s ease;
    }

    .password-toggle:hover {
        background-color: #e9ecef;
    }

    .btn {
        padding: 12px 24px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
    }

    .btn-secondary {
        background-color: #95a5a6;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #7f8c8d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(149, 165, 166, 0.5);
    }

    .form-text {
        color: #7f8c8d;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    .alert {
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border: none;
    }

    .alert-danger {
        background-color: #fff3f3;
        color: #e74c3c;
        border-left: 4px solid #e74c3c;
    }

    .alert-success {
        background-color: #f0fff4;
        color: #27ae60;
        border-left: 4px solid #27ae60;
    }

    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
        
        .bg-white {
            padding: 20px;
        }
        
        .btn {
            padding: 10px 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
    }

    .form-control, .btn {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>