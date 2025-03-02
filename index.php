<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife Personal Training - Transformasi Tubuh Anda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">FitLife</div>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#services">Layanan</a></li>
                <li><a href="#testimonials">Testimonial</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <!-- Section Beranda -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Transformasi Tubuh Anda Bersama FitLife</h1>
            <p>Personal Trainer Profesional untuk Hasil Maksimal</p>
            <a href="#contact" class="cta-button">Hubungi Sekarang</a>
        </div>
    </section>

    <!-- Section Layanan -->
    <section id="services" class="services">
        <h2>Layanan Kami</h2>
        <div class="services-container">
            <div class="service-card">
                <h3>Latihan Personal</h3>
                <p>Program latihan yang disesuaikan dengan kebutuhan Anda, baik di gym maupun di rumah.</p>
            </div>
            <div class="service-card">
                <h3>Konsultasi Nutrisi</h3>
                <p>Rencana diet sehat dan personal untuk mendukung tujuan kebugaran Anda.</p>
            </div>
            <div class="service-card">
                <h3>Pelatihan Online</h3>
                <p>Latihan virtual dengan panduan langsung dari trainer kami melalui video call.</p>
            </div>
        </div>
    </section>

    <!-- Section Testimonial -->
    <section id="testimonials" class="testimonials">
        <h2>Apa Kata Klien Kami?</h2>
        <div class="testimonial-container">
            <div class="testimonial-card">
                <p>"FitLife benar-benar mengubah hidup saya! Saya berhasil turun 10 kg dalam 3 bulan!"</p>
                <h4>- Andi S.</h4>
            </div>
            <div class="testimonial-card">
                <p>"Program nutrisi dari FitLife sangat membantu saya mencapai target kebugaran saya."</p>
                <h4>- Bima K.</h4>
            </div>
        </div>
    </section>

    <!-- Section Kontak -->
    <section id="contact" class="contact">
        <h2>Hubungi Kami</h2>
        <form action="send_email.php" method="POST">
            <input type="text" name="name" placeholder="Nama Anda" required>
            <input type="email" name="email" placeholder="Email Anda" required>
            <textarea name="message" placeholder="Pesan Anda" required></textarea>
            <button type="submit">Kirim Pesan</button>
        </form>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 FitLife Personal Training. All rights reserved.</p>
    </footer>
</body>
</html>
