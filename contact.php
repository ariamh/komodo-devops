<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife Personal Training - Kontak</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
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

    <!-- Section Kontak -->
    <section id="contact" class="contact py-16 px-4 min-h-screen flex items-center">
        <div class="max-w-lg mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Hubungi Kami</h2>
            <form action="send_email.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                <input type="text" name="name" placeholder="Nama Anda" required class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                <input type="email" name="email" placeholder="Email Anda" required class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                <textarea name="message" placeholder="Pesan Anda" required class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 h-32"></textarea>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold w-full">Kirim Pesan</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p class="py-4">© 2025 FitLife Personal Training. All rights reserved.</p>
    </footer>
</body>
</html>
