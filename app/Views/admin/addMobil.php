<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Tambah Mobil</h1>

    <!-- Pesan Sukses atau Kesalahan -->
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

    <div class="info mb-4">
        <h5>Petunjuk Pengisian</h5>
        <p>Pastikan untuk mengisi semua field yang diperlukan dengan benar. Gambar mobil yang diunggah harus jelas dan dapat merepresentasikan kendaraan dengan baik.</p>
    </div>

    <form action="/admin/storeMobil" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="merk">
                <i class="fas fa-car"></i> Merk
            </label>
            <input type="text" class="form-control" id="merk" name="merk" required placeholder="Masukkan merk mobil">
        </div>
        
        <div class="form-group">
            <label for="model">
                <i class="fas fa-tag"></i> Model
            </label>
            <input type="text" class="form-control" id="model" name="model" required placeholder="Masukkan model mobil">
        </div>
        
        <div class="form-group">
            <label for="harga">
                <i class="fas fa-money-bill-wave"></i> Harga
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input type="text" class="form-control" id="harga" name="harga" required placeholder="Masukkan Harga" oninput="formatHargaManual(this)">
            </div>
            <span class="form-text text-muted">Pastikan informasi yang Anda masukkan sudah benar.</span>
        </div>
        
        <div class="form-group">
            <label for="spesifikasi">
                <i class="fas fa-info-circle"></i> Spesifikasi
            </label>
            <textarea class="form-control" id="spesifikasi" name="spesifikasi" required placeholder="Masukkan spesifikasi mobil..." rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <label for="gambar">
                <i class="fas fa-image"></i> Gambar
            </label>
            <div class="custom-file">
                <input type="file" name="gambar" id="gambar" class="custom-file-input" accept="image/*" required onchange="previewImage(event)">
                <label class="custom-file-label" for="gambar">Pilih gambar...</label>
            </div>
            <small class="form-text text-muted">Upload gambar mobil (format .jpg, .jpeg, .png).</small>
            <div id="imagePreview" style="margin-top: 10px;">
                <img id="preview" src="" alt="Image Preview" style="display: none; max-width: 200px;"/>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

    </form>
</div>

<script>
    function formatHargaManual(input) {
        let value = input.value.replace(/[^\d]/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = value;
    }

    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('.custom-file-input');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : "Pilih gambar...";
                this.nextElementSibling.innerText = fileName;
            });
        }

        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const hargaInput = document.getElementById('harga');
                if (hargaInput) {
                    hargaInput.value = hargaInput.value.replace(/\./g, '');
                }
            });
        }
    });
</script>
<style>
    .container {
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    h1.text-center {
        color: #343a40;
        font-weight: bold;
        text-transform: uppercase;
    }

    .info {
        background-color: #e9ecef;
        border-left: 4px solid #007bff;
        padding: 15px 20px;
        border-radius: 5px;
    }

    .form-group label {
        font-weight: bold;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 5px 0 0 5px;
        font-size: 0.95rem;
        padding: 10px 15px;
        display: flex;
        align-items: center;
    }

    .input-group .form-control {
        border-radius: 0 5px 5px 0; 
        margin-left: -1px;
    }

    .custom-file-label {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .custom-file-label:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }

    #imagePreview {
        margin-top: 10px;
    }

    #imagePreview img {
        display: none;
        max-width: 200px;
        max-height: 200px;
        border: 2px solid #dee2e6;
        border-radius: 5px;
    }

    button.btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s ease;
    }

    button.btn-primary:hover {
        background-color: #0056b3;
    }

    button.btn-secondary {
        background-color: #6c757d;
        border: none;
        transition: background-color 0.3s ease;
    }

    button.btn-secondary:hover {
        background-color: #495057;
    }

    .alert {
        border-radius: 5px;
        padding: 15px;
        font-size: 0.9rem;
    }

    @media (max-width: 576px) {
        .form-group label {
            font-size: 0.9rem;
        }

        .btn {
            font-size: 0.8rem;
            padding: 8px 12px;
        }

        h1.text-center {
            font-size: 1.5rem;
        }

        .info {
            font-size: 0.9rem;
        }
    }
</style>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>