<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-5 display-4">Transaksi Mobil</h1>

    <div class="card shadow-lg p-4 mb-5 bg-white rounded">
        <h3 class="mb-4 text-primary text-center">Mobil yang Dipilih</h3>
        
        <div class="text-center mb-4">
            <img src="<?= base_url('uploads/' . esc($mobil['gambar'])) ?>" class="img-fluid rounded" alt="<?= esc($mobil['merk']) ?>" style="max-width: 50%; height: auto; object-fit: cover;">
        </div>

        <div class="mb-3">
            <p><strong>Merk:</strong> <?= esc($mobil['merk']) ?></p>
            <p><strong>Model:</strong> <?= esc($mobil['model']) ?></p>
            <p><strong>Harga:</strong> Rp. <?= number_format($mobil['harga'], 0, ',', '.') ?></p>
            <p><strong>Spesifikasi:</strong></p>
            <div class="p-3 bg-light border rounded">
                <pre><?= esc($mobil['spesifikasi']) ?></pre>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="card shadow-lg p-4 bg-white rounded">
        <h4 class="text-center text-success mb-4">Konfirmasi Pembelian</h4>
        
        <form action="/user/confirmTransaction" method="post">
            <input type="hidden" name="id_mobil" value="<?= esc($mobil['id_mobil']) ?>">
            
            <!-- Kirim harga diskon jika ada -->
            <input type="hidden" name="harga" value="<?= isset($harga_diskon) ? esc($harga_diskon) : esc($mobil['harga']) ?>">

            <div class="form-group">
                <label for="nama" class="font-weight-bold">Nama Pembeli:</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap Anda" required>
            </div>

            <div class="form-group">
                <label for="telepon" class="font-weight-bold">Nomor Telepon:</label>
                <input type="tel" name="telepon" id="telepon" class="form-control" placeholder="08xxxxxxx" required>
            </div>

            <div class="form-group">
                <label for="alamat" class="font-weight-bold">Alamat Pengiriman:</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat lengkap Anda" required></textarea>
                <small class="form-text text-muted">Pastikan alamat pengiriman lengkap untuk mempercepat proses pengiriman.</small>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-circle"></i> Konfirmasi Pembelian
                </button>
                <a href="/user/dashboard" class="btn btn-secondary btn-lg ms-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Mobil
                </a>
            </div>
        </form>
    </div>

    <div class="mt-5 text-center">
        <p class="text-muted">Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami di nomor telepon yang tertera di bawah ini.</p>
        <p class="font-weight-bold">
            <a href="https://wa.me/6282245222599" class="text-success" style="text-decoration: none;">
                <i class="fab fa-whatsapp fa-lg me-2"></i> +62 822-4522-2599
            </a>
        </p>
    </div>
</div>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1300px;
        margin: 20px auto;
        padding: 15px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        flex: 1 0 auto;
    }

    .card {
        max-width: 1200px; 
        border: none;
        border-radius: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    h1.display-4 {
        font-weight: 700;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn {
        border-radius: 25px;
        padding: 10px 20px;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .form-group label {
        font-weight: bold;
        color: #495057;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    textarea.form-control {
        resize: none;
    }

    .text-primary {
        color: #007bff !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    a.text-success {
        font-size: 1.1em;
        font-weight: bold;
    }

    a.text-success:hover {
        text-decoration: underline;
    }

    .mt-5 {
        margin-top: 3rem !important;
    }

    .mb-5 {
        margin-bottom: 3rem !important;
    }

    .shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }
</style>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>