<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-4 text-primary">Edit User</h1>

    <?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('message') ?>
    </div>
    <?php elseif (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-4 rounded shadow-sm">
        <form action="/admin/updateUser/<?= $user['id_pengguna'] ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="nama"><i class="fas fa-user"></i> Nama :</label>
                <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama']) ?>" placeholder="Masukkan nama lengkap" required>
                <small class="form-text text-muted">Nama lengkap Anda yang akan ditampilkan di akun.</small>
                <?php if (isset($validation)): ?>
                    <div class="text-danger"><?= esc($validation->getError('nama')) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email :</label>
                <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" placeholder="Masukkan email" required>
                <small class="form-text text-muted">Email yang digunakan untuk login dan menerima notifikasi.</small>
                <?php if (isset($validation)): ?>
                    <div class="text-danger"><?= esc($validation->getError('email')) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="telepon"><i class="fas fa-phone"></i> Telepon :</label>
                <input type="text" name="telepon" class="form-control" value="<?= old('telepon', $user['telepon']) ?>" placeholder="Masukkan nomor telepon" required>
                <small class="form-text text-muted">Nomor telepon yang dapat dihubungi.</small>
                <?php if (isset($errors['telepon'])): ?>
                    <div class="text-danger"><?= esc($errors['telepon']) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat :</label>
                <textarea name="alamat" class="form-control" rows="4" placeholder="Masukkan alamat lengkap" required><?= old('alamat', $user['alamat']) ?></textarea>
                <small class="form-text text-muted">Masukkan alamat lengkap untuk pengiriman atau keperluan lainnya.</small>
                <?php if (isset($errors['alamat'])): ?>
                    <div class="text-danger"><?= esc($errors['alamat']) ?></div>
                <?php endif; ?>
            </div>

            <input type="hidden" name="role" value="<?= esc($user['role']) ?>">

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Update
                </button>
                <a href="/admin/manageUsers" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

<style>
    body {
        margin: 0;
        padding: 0;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff; 
        transition: background-color 0.3s, transform 0.2s; 
        padding: 0.375rem 0.75rem;
        margin: 10px;
    }

    .btn-primary:hover {
        background-color: #0056b3; 
        transform: translateY(-2px); 
    }

    .btn-secondary {
        background-color: #6c757d; 
        border-color: #6c757d;
        transition: background-color 0.3s, transform 0.2s; 
        padding: 0.375rem 0.75rem;
        margin: 10px;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }

    .form-group {
        margin-bottom: 1rem; /* Mengatur jarak antar form group */
    }

    .form-text {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: -5px; /* Memberikan jarak lebih sedikit pada bagian atas */
        margin-bottom: 0px; /* Menghilangkan jarak bawah, sehingga lebih dekat ke input */
        line-height: 1.5; /* Menyesuaikan tinggi garis agar lebih rapat */
    }

    .form-control {
        padding: 10px; /* Menambah padding dalam input */
        margin-bottom: 5px; /* Mengatur jarak antara input dan teks penjelasan */
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .container {
        margin: 20px auto;
        padding: 20px;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 15px;
        padding: 10px 0;
        text-align: center;
    }

    footer {
        padding: 20px;
        text-align: center;
        margin-top: 20px;
    }
</style>

<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>