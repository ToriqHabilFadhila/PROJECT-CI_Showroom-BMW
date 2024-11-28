<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">
        <i class="fas fa-car-edit"></i> Edit Mobil
    </h1>

    <p class="text-center mb-4">Silakan ubah informasi mobil di bawah ini. Pastikan semua data yang dimasukkan benar sebelum menyimpan perubahan.</p>

    <!-- Pesan Sukses atau Kesalahan -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="/admin/updateMobil/<?= $mobil['id_mobil'] ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="merk">
                <i class="fas fa-car"></i> Merk
            </label>
            <input type="text" class="form-control" name="merk" value="<?= esc($mobil['merk']) ?>" required placeholder="Masukkan merk mobil">
        </div>

        <div class="form-group">
            <label for="model">
                <i class="fas fa-car-side"></i> Model
            </label>
            <input type="text" class="form-control" name="model" value="<?= esc($mobil['model']) ?>" required placeholder="Masukkan model mobil">
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
            <textarea class="form-control" name="spesifikasi" required placeholder="Masukkan spesifikasi mobil..." rows="4"><?= esc($mobil['spesifikasi']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="gambar">
                <i class="fas fa-image"></i> Gambar
            </label>
            <div class="custom-file mb-3">
                <input type="file" name="gambar" id="gambar" class="custom-file-input" accept="image/*" onchange="previewImage(event)">
                <label class="custom-file-label" for="gambar">Pilih gambar...</label>
            </div>
            <small class="form-text text-muted">Upload gambar mobil (format .jpg, .jpeg, .png).</small>
            <div id="imagePreview" style="margin-top: 10px;">
                <img id="preview" src="" alt="Image Preview" style="display: none; max-width: 200px;"/>
            </div>
        </div>

        <div class="form-group mt-4">
            <label>Gambar Mobil Saat Ini</label>
            <div class="current-image">
                <img src="<?= base_url('uploads/' . esc($mobil['gambar'])) ?>" class="img-fluid rounded" alt="<?= esc($mobil['merk']) ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="/admin/manageMobil" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </form>
</div>

<script>
    function formatHargaManual(input) {
        let value = input.value.replace(/[^\d.]/g, '');
        value = value.replace(/\./g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
        input.value = value;
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const hargaInput = document.getElementById('harga');
        // Remove all dots before submitting
        hargaInput.value = hargaInput.value.replace(/\./g, '');
    });

    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const imagePreviewDiv = document.getElementById('imagePreview');
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

    document.querySelector('.custom-file-input').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : "Pilih gambar...";
        const nextSibling = this.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>