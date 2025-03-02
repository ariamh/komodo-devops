<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Konfigurasi email (ganti dengan email Anda)
    $to = "your-email@example.com"; // Ganti dengan email Anda
    $subject = "Pesan Baru dari $name - FitLife";
    $body = "Nama: $name\nEmail: $email\nPesan:\n$message";
    $headers = "From: $email";

    // Kirim email
    if (mail($to, $subject, $body, $headers)) {
        echo "<p>Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.</p>";
    } else {
        echo "<p>Maaf, terjadi kesalahan saat mengirim pesan. Coba lagi nanti.</p>";
    }
} else {
    echo "<p>Metode pengiriman tidak valid.</p>";
}
?>
