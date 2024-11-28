<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="display-4 text-center mb-4">Riwayat Transaksi Anda</h1>
    
    <p class="text-center mb-4">Berikut adalah daftar semua transaksi yang telah Anda lakukan. Pastikan untuk memeriksa status setiap transaksi.</p>

    <!-- Tombol Kembali -->
    <div class="text-center mb-3">
        <a href="/user/dashboard" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksi)): ?>
                    <?php foreach ($transaksi as $item): ?>
                        <tr>
                            <td><?= esc($item['id_transaksi']) ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($item['tanggal'])) ?></td>
                            <td>Rp. <?= number_format($item['total_harga'], 2, ',', '.') ?></td>
                            <td>
                                <span class="badge <?= ($item['status'] == 'Completed') ? 'bg-success' : (($item['status'] == 'Cancelled') ? 'bg-danger' : 'bg-warning') ?>">
                                    <i class="<?= ($item['status'] == 'Completed') ? 'fas fa-check-circle' : (($item['status'] == 'Cancelled') ? 'fas fa-times-circle' : 'fas fa-hourglass-half') ?>"></i>
                                    <?= ucfirst($item['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada riwayat transaksi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    :root {
        --primary-color: #343a40;
        --secondary-color: #6c757d;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --light-color: #f9f9f9;
        --border-color: #dee2e6;
        --border-radius-lg: 15px;
        --border-radius-md: 10px;
        --border-radius-sm: 5px;
        --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 15px;
        background-color: var(--light-color);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--box-shadow);
    }

    h1.display-4 {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        letter-spacing: -0.5px;
    }

    .text-center {
        text-align: center;
    }

    p.text-center {
        color: var(--secondary-color);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }

    .btn-secondary {
        background-color: var(--secondary-color);
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.2);
    }

    .table-responsive {
        background: white;
        border-radius: var(--border-radius-md);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        background-color: transparent;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        background-color: #f8f9fa;
        color: var(--primary-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        color: var(--secondary-color);
        font-size: 1rem;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .badge {
        padding: 0.6rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
    }

    .badge i {
        font-size: 0.9rem;
    }

    .bg-success {
        background-color: rgba(40, 167, 69, 0.1) !important;
        color: var(--success-color);
    }

    .bg-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
        color: #856404;
    }

    .bg-danger {
        background-color: rgba(220, 53, 69, 0.1) !important;
        color: var(--danger-color);
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

    .container {
        animation: fadeIn 0.5s ease-out;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
            margin: 1rem;
        }

        h1.display-4 {
            font-size: 2rem;
        }

        .table {
            display: block;
        }

        .table tbody {
            display: block;
        }

        .table tr {
            display: block;
            background: white;
            margin-bottom: 1rem;
            border-radius: var(--border-radius-sm);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            text-align: right;
            border-bottom: 1px solid var(--border-color);
        }

        .table td::before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
            text-align: left;
            color: var(--primary-color);
        }

        .badge {
            margin-left: auto;
        }
    }

    @media print {
        .container {
            box-shadow: none;
            margin: 0;
            padding: 0;
        }

        .btn-secondary {
            display: none;
        }

        .table th,
        .table td {
            padding: 0.5rem;
        }
    }
</style>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>