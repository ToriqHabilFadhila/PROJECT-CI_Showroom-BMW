<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-5 display-4">Pembayaran</h1>
    
    <div class="text-center mb-4">
        <img src="<?= base_url('assets/images/LOGO.png') ?>" alt="Pembayaran" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
    </div>

    <div class="card shadow-lg p-4 bg-white rounded">
        <h4 class="text-center text-primary mb-4">Detail Transaksi</h4>
        
        <?php if (isset($transaksi)): ?>
            <p><strong>Transaksi ID:</strong> <?= esc($transaksi['id_transaksi']) ?></p>
            <p><strong>Total Harga:</strong> Rp. <?= number_format($transaksi['total_harga'], 2, ',', '.') ?></p>
            <input type="hidden" id="total_harga" value="<?= esc($transaksi['total_harga']) ?>">
            <p><strong>Status:</strong> <?= esc($transaksi['status']) ?></p>
        <?php else: ?>
            <div class="alert alert-warning text-center">Tidak ada data transaksi yang ditemukan.</div>
        <?php endif; ?>
    </div>

    <?php if (isset($transaksi)): ?>
        <div class="card shadow-lg p-4 mt-4 bg-white rounded">
            <h4 class="text-center text-success mb-4">Konfirmasi Pembayaran</h4>
            
            <form action="/user/makePayment" method="POST" enctype="multipart/form-data" onsubmit="return validatePayment()">
                <input type="hidden" name="id_transaksi" value="<?= esc($transaksi['id_transaksi']) ?>">
                
                <div class="form-group">
                    <label for="metode_pembayaran" class="font-weight-bold">Metode Pembayaran:</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                        <option value="">Pilih Metode</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Kartu Kredit">Kartu Kredit</option>
                        <option value="PayPal">PayPal</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah" class="font-weight-bold">Jumlah Pembayaran:</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required readonly>
                </div>

                <div class="form-group">
                    <label for="bukti_pembayaran">Bukti Pembayaran</label>
                    <div class="custom-file">
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="custom-file-input" accept="image/*" required onchange="previewImage(event)">
                        <label class="custom-file-label" for="bukti_pembayaran">Pilih bukti pembayaran...</label>
                    </div>
                    <small class="form-text text-muted">Upload bukti pembayaran dalam format .jpg, .jpeg, atau .png.</small>
                    <div id="imagePreview" class="mt-3">
                        <img id="preview" src="" alt="Image Preview" style="display: none; max-width: 200px;"/>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-check-circle"></i> Konfirmasi Pembayaran</button>
                    <a href="/user/dashboard" class="btn btn-secondary btn-lg ml-2"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <div class="mt-5 text-center">
        <p class="text-muted">Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami di nomor telepon yang tertera di bawah ini.</p>
        <p class="font-weight-bold">
            <a href="https://api.whatsapp.com/send?phone=6282245222599&text=Halo%20saya%20mau%20tanya%20tentang%20produk" class="text-success" style="text-decoration: none;">
                <i class="fab fa-whatsapp fa-lg me-2"></i> +62 822-4522-2599
            </a>
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalHarga = parseFloat(document.getElementById('total_harga').value);
        document.getElementById('jumlah').value = totalHarga.toFixed(2);
    });

    function validatePayment() {
        const totalHarga = parseFloat(document.getElementById('total_harga').value);
        const jumlah = parseFloat(document.getElementById('jumlah').value);
        const metodePembayaran = document.getElementById('metode_pembayaran').value;
        const buktiPembayaran = document.getElementById('bukti_pembayaran').files.length;

        if (jumlah !== totalHarga) {
            alert('Jumlah pembayaran tidak sesuai dengan total harga!');
            return false;
        }

        if (!metodePembayaran) {
            alert('Pilih metode pembayaran terlebih dahulu!');
            return false;
        }

        if (buktiPembayaran === 0) {
            alert('Anda harus mengupload bukti pembayaran!');
            return false;
        }

        return true;
    }


    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
</script>
<style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #6c757d;
        --dark-color: #343a40;
        --light-color: #f9f9f9;
        --border-radius-lg: 15px;
        --border-radius-md: 10px;
        --border-radius-sm: 5px;
        --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background-color: var(--light-color);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--box-shadow);
    }

    h1.display-4 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 2rem;
        font-size: 2.5rem;
        letter-spacing: -0.5px;
    }

    h4 {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--dark-color);
    }

    .card {
        max-width: 1080px;
        margin: 0 auto;
        border-radius: var(--border-radius-md);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        background: #ffffff;
        border: none;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    input#jumlah[readonly] {
        background-color: #e9ecef;
        border: 1px solid #ced4da; 
        border-radius: 10px; 
        color: #495057;
        cursor: not-allowed; 
        box-shadow: none;
    }

    .form-group label {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border-radius: var(--border-radius-sm);
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        outline: none;
    }

    .custom-file {
        position: relative;
        margin-bottom: 1rem;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.5em + 1.5rem);
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        padding: 0.75rem 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--secondary-color);
        background-color: #fff;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-sm);
        transition: var(--transition);
    }

    .btn {
        border-radius: 50px;
        padding: 0.75rem 1.0rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-success {
        background-color: var(--primary-color);
        border: none;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }

    .btn-secondary {
        background-color: var(--secondary-color);
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
    }

    #imagePreview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: var(--border-radius-sm);
        box-shadow: var(--box-shadow);
        object-fit: cover;
    }

    .contact-section {
        margin-top: 3rem;
        text-align: center;
    }

    .contact-section p {
        color: var(--secondary-color);
        line-height: 1.6;
    }

    .contact-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .contact-link:hover {
        color: #218838;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        h1.display-4 {
            font-size: 2rem;
        }

        .card {
            padding: 1.5rem;
        }

        .btn {
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn:last-child {
            margin-bottom: 0;
        }
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

    .card {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>