<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center display-5 mb-4">Kelola Pembayaran</h1>

    <!-- Pesan Sukses atau Kesalahan -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID Pembayaran</th>
                    <th>ID Transaksi</th>
                    <th>Jumlah</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Bukti Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pembayaran)): ?>
                    <?php foreach ($pembayaran as $pembayaranItem): ?>
                        <tr>
                            <td><?= esc($pembayaranItem['id_pembayaran']) ?></td>
                            <td><?= esc($pembayaranItem['id_transaksi']) ?></td>
                            <td>Rp. <?= number_format($pembayaranItem['jumlah'], 2, ',', '.') ?></td>
                            <td><?= esc($pembayaranItem['metode_pembayaran']) ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($pembayaranItem['tanggal_pembayaran'])) ?></td>
                            <td>
                                <?php if (!empty($pembayaranItem['bukti_pembayaran'])): ?>
                                    <a href="<?= base_url('uploads/bukti_pembayaran/' . esc($pembayaranItem['bukti_pembayaran'])) ?>" target="_blank">Lihat Bukti</a>
                                <?php else: ?>
                                    Tidak ada bukti
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pembayaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="/admin/dashboard" class="btn btn-secondary btn-lg">Kembali ke Dashboard</a>
    </div>
</div>

<style>
    .table {
        border-collapse: collapse;
        width: 100%;
        margin: 0 auto;
    }
    .table th, .table td {
        text-align: left;
        padding: 12px;
    }
    .thead-dark th {
        background-color: #343a40;
        color: white;
    }
    .btn-link {
        color: #007bff;
        text-decoration: underline;
    }
    .btn-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }
</style>

<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>