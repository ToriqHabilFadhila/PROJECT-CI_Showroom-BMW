<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <!-- Header -->
    <h1 class="text-center display-5 mb-4">Kelola Pembayaran dan Transaksi</h1>

        <!-- Flash Messages -->
    <?php if (session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible fade show text-center">
            <?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="transaksi-tab" data-bs-toggle="tab" 
                    data-bs-target="#transaksi" type="button" role="tab" 
                    aria-controls="transaksi" aria-selected="true">
                <i class="fas fa-exchange-alt"></i> Transaksi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pembayaran-tab" data-bs-toggle="tab" 
                    data-bs-target="#pembayaran" type="button" role="tab" 
                    aria-controls="pembayaran" aria-selected="false">
                <i class="fas fa-money-bill-wave"></i> Pembayaran
            </button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="myTabContent">
        <!-- Transactions Tab -->
        <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab">
            <div class="row">
                <?php if (!empty($transaksi)): ?>
                    <?php foreach ($transaksi as $item): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm hover-card">
                                <!-- Transaction Card Header -->
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">ID Transaksi: #<?= esc($item['id_transaksi']) ?></h5>
                                </div>
                                
                                <!-- Transaction Card Body -->
                                <div class="card-body">
                                    <!-- Customer Info -->
                                    <div class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-user"></i> Pelanggan</h6>
                                        <p class="mb-1"><?= esc($item['nama_pengguna']) ?></p>
                                    </div>
                                    
                                    <!-- Car Details -->
                                    <div class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-car"></i> Detail Mobil</h6>
                                        <p class="mb-1"><?= esc($item['merk_mobil']) ?> <?= esc($item['model']) ?></p>
                                    </div>

                                    <!-- Date -->
                                    <div class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-calendar-alt"></i> Tanggal</h6>
                                        <p class="mb-1"><?= date('d-m-Y H:i', strtotime($item['tanggal'])) ?></p>
                                    </div>

                                    <!-- Total Price -->
                                    <div class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-money-bill-wave"></i> Total Harga</h6>
                                        <p class="mb-1">Rp. <?= number_format($item['total_harga'], 0, ',', '.') ?></p>
                                    </div>

                                    <!-- Payment Proof -->
                                    <?php if (isset($item['bukti_pembayaran'])): ?>
                                    <div class="mb-3">
                                        <h6 class="fw-bold"><i class="fas fa-file-invoice"></i> Bukti Pembayaran</h6>
                                        <div class="mt-2">
                                            <a href="<?= base_url('uploads/bukti_pembayaran/' . $item['bukti_pembayaran']) ?>" 
                                                class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-eye"></i> Lihat Bukti
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Status Update Form -->
                                    <form action="<?= base_url('admin/updateStatusTransaksi/' . $item['id_transaksi']) ?>" method="post" class="mt-3">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-8">
                                                <select name="status" class="form-select form-select-sm" 
                                                        <?= ($item['status'] === 'Completed' || $item['status'] === 'Cancelled') ? 'disabled' : '' ?>>
                                                    <option value="Completed" <?= $item['status'] === 'Completed' ? 'selected' : '' ?>>
                                                        Completed
                                                    </option>
                                                    <option value="Cancelled" <?= $item['status'] === 'Cancelled' ? 'selected' : '' ?>>
                                                        Cancelled
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <?php if ($item['status'] !== 'Completed' && $item['status'] !== 'Cancelled'): ?>
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                                        <i class="fas fa-sync-alt"></i> Update
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Delete Transaction Button -->
                                        <?php if ($item['status'] !== 'Completed' && $item['status'] !== 'Cancelled'): ?>
                                            <div class="mt-2">
                                                <a href="<?= site_url('admin/deleteTransaksi/' . $item['id_transaksi']) ?>" 
                                                    class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Semua data pembayaran terkait juga akan dihapus.');">
                                                    <i class="fas fa-trash-alt"></i> Hapus Transaksi
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </form>
                                </div>

                                <!-- Transaction Card Footer -->
                                <div class="card-footer">
                                    <span class="badge <?= getStatusBadgeClass($item['status']) ?>">
                                        <i class="fas <?= getStatusIcon($item['status']) ?>"></i> <?= $item['status'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> Belum ada data transaksi.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pembayaran (Riwayat Transaksi) -->
        <div class="tab-pane fade" id="pembayaran" role="tabpanel" aria-labelledby="pembayaran-tab">
            <div class="container mt-5">
                <h1 class="text-center">Riwayat Transaksi</h1>

                <!-- Pesan Sukses atau Kesalahan -->
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success text-center">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger text-center">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Tanggal</th>
                                <th>Bukti</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transaksi)): ?>
                                <?php foreach ($transaksi as $item): ?>
                                    <tr>
                                        <td><?= esc($item['id_transaksi']) ?></td>
                                        <td>
                                            <?= esc($item['merk_mobil']) ?> <?= esc($item['model']) ?><br>
                                            <small class="text-muted">ID: #<?= esc($item['id_transaksi']) ?></small>
                                        </td>
                                        <td><?= esc($item['nama_pengguna']) ?></td>
                                        <td>
                                            <?php if (!empty($item['jumlah'])): ?>
                                                Rp. <?= number_format($item['jumlah'], 0, ',', '.') ?>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ada pembayaran</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= !empty($item['metode_pembayaran']) ? esc($item['metode_pembayaran']) : '<span class="text-muted">Tidak ada metode</span>' ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (!empty($item['tanggal_pembayaran'])) {
                                                echo date('d/m/Y H:i', strtotime($item['tanggal_pembayaran']));
                                            } else {
                                                echo '<span class="text-muted">Tanggal tidak tersedia</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['bukti_pembayaran'])): ?>
                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $item['bukti_pembayaran']) ?>" 
                                                    class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-file-image"></i> Lihat
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Tidak ada bukti</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= getStatusBadgeClass($item['status']) ?>">
                                                <?= esc($item['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data pembayaran.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="/admin/dashboard" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<?php
// Helper Functions
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'Completed':
            return 'bg-success';
        case 'Processing':
            return 'bg-warning';
        case 'Cancelled':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}

function getStatusIcon($status) {
    switch ($status) {
        case 'Completed':
            return 'fa-check-circle';
        case 'Cancelled':
            return 'fa-times-circle';
        default:
            return 'fa-question-circle';
    }
}
?>

<style>
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .card-header {
        border-bottom: none;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0,0,0,0.125);
    }

    .badge {
        font-size: 0.875rem;
        padding: 0.5em 0.75em;
    }

    .table th {
        white-space: nowrap;
        background-color: #343a40;
        color: white;
    }

    .nav-tabs .nav-link {
        color: #495057;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 0.75rem 1.25rem;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: none;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        border-bottom: 2px solid #dee2e6;
    }

    @media (max-width: 768px) {
        .card-title {
            font-size: 1rem;
        }
        
        .badge {
            font-size: 0.75rem;
        }
        
        .table {
            font-size: 0.875rem;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>