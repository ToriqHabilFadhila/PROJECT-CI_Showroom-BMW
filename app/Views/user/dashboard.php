<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="<?= base_url('assets/images/Desain.png') ?>" alt="BMW Word" class="logo">
            <span class="ms-2 fw-bold fs-4 text-dark">BMW Collection</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> 
                <li class="nav-item">
                    <a class="nav-link" href="/user/riwayatTransaksi">Lihat Riwayat Transaksi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-4">Portal Pelanggan Showroom BMW</h1>
    
    <div class="text-center mb-4">
        <img src="<?= base_url('assets/images/BMW.png') ?>" class="img-fluid" alt="Showroom BMW">
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <form id="searchForm" class="d-flex">
                <input type="text" id="searchInput" class="form-control me-2" placeholder="Cari mobil berdasarkan merk atau model" aria-label="Search">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button type="button" id="resetSearch" class="btn btn-secondary ms-2" style="display: none;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="text-center mb-4">
        <p class="date-message">
            <strong class="text-primary">Nikmati Keindahan Hari Ini</strong><br>
            <span class="display-date"><?= $hari . ', ' . date('j F Y'); ?></span>
        </p>
        <div class="wave-divider"></div>
    </div>
    
    <?php if (session()->getFlashdata('welcome_message')): ?>
        <div id="welcomePopup" class="welcome-popup">
            <div class="popup-header">
                <i class="fas fa-smile" aria-hidden="true" style="font-size: 30px; color: #28a745; margin-right: 10px;"></i>
                <span class="popup-title">Selamat Datang!</span>
                <span class="popup-close" onclick="closePopup()">×</span>
            </div>
            <p class="popup-message"><?= session()->getFlashdata('welcome_message'); ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($inspirational_message)): ?>
        <div class="alert alert-info text-center fade-in inspirational-alert">
            <strong>Pesan Hari Ini :</strong> <?= esc($inspirational_message) ?>
        </div>
    <?php endif; ?>
    
    <h2 class="text-center mt-5">Temukan Mobil Impian Anda</h2>
    <div class="row mt-4" id="mobilContainer">
        <?php if ($mobils): ?>
            <?php foreach ($mobils as $mobil): ?>
                <div class="col-md-4 col-sm-6 mb-4 mobil-item" data-search="<?= strtolower(esc($mobil['merk'] . ' ' . $mobil['model'])) ?>">
                    <div class="card shadow-sm h-100 border-0">
                        <img src="<?= base_url('uploads/' . esc($mobil['gambar'])) ?>" class="card-img-top" alt="<?= esc($mobil['merk']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center"><?= esc($mobil['merk']) . ' ' . esc($mobil['model']) ?></h5>
                            <p class="card-text text-center"><strong>Harga:</strong> Rp. <?= number_format($mobil['harga'], 2, ',', '.') ?></p>
                            <div class="card">
                                <div class="card-body">
                                    <div class="spesifikasi mt-auto">
                                        <strong>Spesifikasi:</strong>
                                        <div class="short-spec">
                                            <p class="text-muted"><?= esc(substr($mobil['spesifikasi'], 0, 100)) ?>...</p>
                                        </div>
                                        <div class="full-spec d-none">
                                            <pre class="text-muted"><?= esc($mobil['spesifikasi']) ?></pre>
                                        </div>
                                        <button class="btn btn-link text-decoration-none text-primary show-more">Tampilkan Lebih Banyak</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="/user/transaksi/<?= esc($mobil['id_mobil']) ?>" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart"></i> Beli Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="alert alert-warning">Tidak ada mobil tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>

    <div id="noResultsMessage" class="text-center d-none">
        <div class="alert alert-warning">
            Tidak ada mobil yang cocok dengan pencarian "<strong id="searchTermDisplay"></strong>".
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const mobilContainer = document.getElementById('mobilContainer');
        const resetSearchBtn = document.getElementById('resetSearch');
        const mobilItems = document.querySelectorAll('.mobil-item');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const searchTermDisplay = document.getElementById('searchTermDisplay');

        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value.toLowerCase().trim();
                searchTermDisplay.textContent = searchInput.value;

                let matchFound = false;
                mobilItems.forEach(item => {
                    const searchContent = item.getAttribute('data-search');
                    if (searchContent.includes(searchTerm)) {
                        item.style.display = 'block';
                        matchFound = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                mobilContainer.style.display = matchFound ? 'flex' : 'none';
                noResultsMessage.classList.toggle('d-none', matchFound);
                resetSearchBtn.style.display = 'block';
            });
        }

        if (resetSearchBtn) {
            resetSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                mobilItems.forEach(item => {
                    item.style.display = 'block';
                });
                mobilContainer.style.display = 'flex';
                noResultsMessage.classList.add('d-none');
                resetSearchBtn.style.display = 'none';
            });
        }

        document.querySelectorAll('.show-more').forEach(button => {
            button.addEventListener('click', function() {
                const parentCard = button.closest('.card');
                const shortSpec = parentCard.querySelector('.short-spec');
                const fullSpec = parentCard.querySelector('.full-spec');

                if (fullSpec.classList.contains('d-none')) {
                    fullSpec.classList.remove('d-none');
                    shortSpec.classList.add('d-none');
                    button.textContent = 'Tampilkan Lebih Sedikit';
                } else {
                    fullSpec.classList.add('d-none');
                    shortSpec.classList.remove('d-none');
                    button.textContent = 'Tampilkan Lebih Banyak';
                }
            });
        });

        const alert = document.querySelector('.alert-success');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 1s ease';
            }, 4000);
        }

        function closePopup() {
            const popup = document.getElementById('welcomePopup') || document.getElementById('defaultPopup');
            if (popup) {
                popup.classList.add('fade-out');
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 500);
            }
        }

        const welcomePopup = document.getElementById('welcomePopup');
        if (welcomePopup) {
            setTimeout(closePopup, 5000);
        }

        document.querySelectorAll('.popup-close').forEach(button => {
            button.addEventListener('click', closePopup);
        });
    });
</script>

<style>
    body {
        background: url('<?= base_url("assets/images/Dashboard Image.jpg") ?>') no-repeat center center fixed;
        background-size: cover; 
        background-attachment: fixed;
        background-position: center;
        background-blend-mode: overlay;
        background-color: rgba(28, 28, 28, 0.7);
        font-family: 'Montserrat', sans-serif; 
        margin: 0;
        padding: 0;
        color: #333;
        transition: padding-top var(--transition-speed) ease, background-color 0.3s ease;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: inherit; 
        filter: blur(5px);
        z-index: -1;
    }

    .navbar {
        background-color: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    @media (max-width: 768px) {
        body {
            background-position: center center;
            background-size: cover;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.8);
        }
    }

    .card {
        width: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        background-color: #fff;
        border-radius: 8px;
        padding: 15px;
    }

    .card:hover {
        transform: scale(1.05);
        background-color: rgba(255, 255, 255, 0.9);
        cursor: pointer;
    }

    .card:focus {
        outline: none;
        border: 2px solid #0066B1;
        box-shadow: 0 0 15px rgba(0, 102, 177, 0.5);
    }

    .welcome-popup {
        position: fixed;
        top: 20px;
        right: 20px;
        max-width: 600px;
        width: 100%;
        background: #f8f9fa;
        color: black;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        font-family: 'Montserrat', sans-serif;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        animation: slideInBounce 0.7s ease-out;
        opacity: 1;
        visibility: visible;
        transition: opacity 0.5s ease, transform 0.5s ease-out;
    }

    .welcome-popup.fade-out {
        opacity: 0;
        visibility: hidden;
        transition: visibility 0s 0.5s, opacity 0.5s ease-out;
    }

    @keyframes slideInBounce {
        0% {
            transform: translateY(-50px);
            opacity: 0;
        }
        60% {
            transform: translateY(10px);
            opacity: 1;
        }
        100% {
            transform: translateY(0);
        }
    }

    @media (max-width: 480px) {
        .welcome-popup {
            top: 10px; 
            right: 10px;
            max-width: 90%; 
        }
    }

    .welcome-popup button {
        background-color: #0066B1;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .welcome-popup button:hover {
        background-color: #004f8e;
        transform: scale(1.05);
    }

    .welcome-popup button:focus {
        outline: none;
        box-shadow: 0 0 5px 2px rgba(0, 102, 177, 0.5);
    }

    .date-message {
        font-size: 1.2rem;
        font-family: 'Arial', sans-serif;
        color: #333;
        text-align: center;
    }

    .date-message strong {
        font-size: 1.5rem;
        color: #007bff;
    }

    .display-date {
        font-size: 1.2rem;
        color: #555;
        font-weight: bold;
        margin-top: 5px;
        display: inline-block;
        padding: 5px 10px;
        background-color: #f1f1f1;
        border-radius: 8px;
    }
    .wave-divider {
        width: 100%;
        height: 5px;
        background: linear-gradient(45deg, #28a745 25%, #007bff 75%);
        background-size: 50% 100%;
        animation: wave 1.5s ease-in-out infinite;
        margin-top: 15px;
    }

    @keyframes wave {
        0% { background-position: 0 0; }
        50% { background-position: 100% 0; }
        100% { background-position: 0 0; }
    }
</style>
<?= $this->include('templates/footer') ?>
<?= $this->endSection() ?>