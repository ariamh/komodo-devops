<?php
// Mulai session
session_start();

// Fungsi untuk menampilkan notifikasi
function displayNotification() {
    if (isset($_SESSION['notification'])) {
        $message = $_SESSION['notification'];
        echo '<div class="notification">' . $message . '</div>';
        
        // Hapus notifikasi setelah ditampilkan
        unset($_SESSION['notification']);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife Personal Training - Layanan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .notification {
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            margin-top: 35px;
            margin-bottom: 15px;
            border-radius: 4px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            animation: fadeOut 5s forwards;
        }
        
        @keyframes fadeOut {
            0% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }
    </style>
</head>
<body>
    <?php displayNotification(); ?>
    <header>
        <nav>
            <div class="logo">FitLife</div>
            <ul class="nav-links">
                <li><a href="home.php">Beranda</a></li>
                <li><a href="services.php">Layanan</a></li>
                <li><a href="testimonials.php">Testimonial</a></li>
                <li><a href="contact.php">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <!-- Section Beranda -->
    <section id="home" class="hero min-h-screen flex items-center justify-center text-center">
        <div class="hero-content p-6 bg-purple-600 bg-opacity-70 rounded-lg">
            <h1 class="text-4xl font-bold mb-4">Transformasi Tubuh Anda Bersama FitLife</h1>
            <p class="text-xl mb-6">Personal Trainer Profesional untuk Hasil Maksimal</p>
            <a href="contact.php" class="cta-button">Hubungi Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p class="py-4">© 2025 FitLife Personal Training. All rights reserved.</p>
    </footer>
</body>
</html>
