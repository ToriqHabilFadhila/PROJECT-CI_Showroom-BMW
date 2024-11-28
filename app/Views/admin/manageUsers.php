<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-4 display-5 fw-bold">
        <i class="fas fa-users"></i> Kelola Pengguna
    </h1>

    <!-- Pesan Sukses atau Kesalahan -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="/admin/addUser" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
        </a>
        <a href="/admin/dashboard" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['id_pengguna']) ?></td>
                            <td><?= esc($user['nama']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= ucfirst(esc($user['role'])) ?></td>
                            <td>
                                <a href="/admin/editUser/<?= esc($user['id_pengguna']) ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="/admin/deleteUser/<?= esc($user['id_pengguna']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada pengguna yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        font-family: 'Montserrat', sans-serif;
        line-height: 1.6;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .container {
        max-width: 1300px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        flex: 1 0 auto;
    }

    .display-5 {
        color: #2c3e50;
        margin-bottom: 2rem;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .display-5 i {
        color: #007bff;
        margin-right: 0.5rem;
    }

    .btn {
        padding: 0.7rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }

    .btn i {
        font-size: 0.9em;
    }

    .btn-primary {
        background-color: #007bff;
        color: #ffffff;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #ffffff;
    }

    .btn-outline-warning {
        color: #ffc107;
        border: 2px solid #ffc107;
        background: transparent;
        padding: 0.4rem 1rem;
    }

    .btn-outline-danger {
        color: #dc3545;
        border: 2px solid #dc3545;
        background: transparent;
        padding: 0.4rem 1rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .table-responsive {
        margin: 2rem 0;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        background-color: #ffffff;
    }

    .table th {
        background-color: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        font-size: 0.95rem;
        color: #444;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 123, 255, 0.02);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: background-color 0.2s ease;
    }

    .alert {
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
        border-left: 4px solid #198754;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
        border-left: 4px solid #dc3545;
    }

    td .btn {
        margin: 0.2rem;
        min-width: auto;
    }

    footer {
        background-color: #007bff;
        color: #ffffff;
        padding: 1.5rem;
        text-align: center;
        margin-top: auto;
        width: 100%;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .container {
            margin: 10px;
            padding: 1rem;
        }

        .display-5 {
            font-size: 1.8rem;
        }

        .d-flex {
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .table-responsive {
            margin: 1rem 0;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            font-size: 0.85rem;
        }

        td .btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
    }

    .text-muted {
        color: #6c757d !important;
    }

    .text-center {
        text-align: center !important;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    .mt-5 {
        margin-top: 3rem !important;
    }
</style>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>