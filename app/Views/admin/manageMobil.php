<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>
        <i class="fas fa-car"></i> <?= esc($title) ?>
    </h1>

    <!-- Pesan Sukses -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <a href="/admin/dashboard" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
    
    <h2>
        <i class="fas fa-list"></i> Daftar Mobil
    </h2>
    <?php if (!empty($mobils)): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mobils as $mobil): ?>
                    <tr>
                        <td><?= esc($mobil['id_mobil']) ?></td>
                        <td><?= esc($mobil['merk']) ?></td>
                        <td><?= esc($mobil['model']) ?></td>
                        <td>Rp. <?= number_format($mobil['harga'], 2, ',', '.') ?></td>
                        <td>
                            <?php if (!empty($mobil['gambar']) && file_exists('uploads/' . esc($mobil['gambar']))): ?>
                                <img src="<?= base_url('uploads/' . esc($mobil['gambar'])) ?>" alt="<?= esc($mobil['model']) ?>" style="width: 100px; height: auto;">
                            <?php else: ?>
                                <img src="<?= base_url('assets/default_image.jpg') ?>" alt="Gambar Tidak Tersedia" style="width: 100px; height: auto;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/admin/editMobil/<?= esc($mobil['id_mobil']) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="/admin/deleteMobil/<?= esc($mobil['id_mobil']) ?>" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus mobil ini?');">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">Tidak ada mobil yang ditambahkan.</div>
    <?php endif; ?>

    <!-- Tombol untuk Menambah Mobil Baru -->
    <a href="/admin/addMobil" class="btn btn-secondary mt-3">
        <i class="fas fa-plus"></i> Tambah Mobil Baru
    </a>
</div>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>
