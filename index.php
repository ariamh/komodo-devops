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
    <title>FitLife Personal Training - Beranda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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

    <main>
        <!-- Section Beranda -->
        <section class="hero">
            <div class="hero-content">
                <h1>Transformasi Tubuh Anda Bersama FitLife</h1>
                <p>Personal Trainer Profesional untuk Hasil Maksimal</p>
                <a href="contact.php" class="cta-button">Hubungi Sekarang</a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p class="py-4">© 2025 FitLife Personal Training. All rights reserved.</p>
    </footer>
</body>
</html>
