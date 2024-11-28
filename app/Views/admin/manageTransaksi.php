<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center display-6 mb-4">Kelola Transaksi</h1>

    <!-- Pesan Sukses atau Kesalahan -->
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row mt-4">
        <?php if (!empty($transaksi)): ?>
            <?php foreach ($transaksi as $item): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm h-100 border-0 rounded-3">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center fw-bold">ID Transaksi: <?= esc($item['id_transaksi']) ?></h5>
                            <p class="card-text"><strong>Nama Pengguna:</strong> <?= esc($item['nama_pengguna']) ?></p>
                            <p class="card-text"><strong>Mobil:</strong> <?= esc($item['merk_mobil']) ?></p>

                            <p class="card-text"><strong>Tanggal:</strong> <?= date('d-m-Y', strtotime($item['tanggal'])) ?></p>
                            <p class="card-text"><strong>Total Harga:</strong> Rp. <?= number_format($item['total_harga'], 2, ',', '.') ?></p>
                            <p class="card-text"><strong>Status:</strong> <span class="badge <?= $item['status'] === 'Completed' ? 'bg-success' : ($item['status'] === 'Cancelled' ? 'bg-danger' : 'bg-warning') ?>"><?= esc($item['status']) ?></span></p>
                            <div class="mt-auto text-center">
                                <form action="<?= base_url('admin/updateStatusTransaksi/' . esc($item['id_transaksi'])) ?>" method="post" class="d-inline">
                                    <select name="status" class="form-select form-select-sm" aria-label="Pilih Status">
                                        <option value="Completed" <?= $item['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="Cancelled" <?= $item['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm ms-2">Perbarui Status</button>
                                    <a href="/admin/deleteTransaksi/<?= esc($item['id_transaksi'])?>" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">Hapus</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-warning">Tidak ada data transaksi.</div>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="/admin/dashboard" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<style>
    .card {
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    .card-body {
        padding: 1.5rem;
    }
    .card-title {
        font-size: 1.25rem;
        color: #333;
    }
</style>

<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>