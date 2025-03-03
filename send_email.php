<?php
session_start();

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fungsi untuk memeriksa batas pengiriman berdasarkan email
function checkRateLimit($email) {
    $max_emails = 3; // Maksimum email per jam
    $time_window = 3600; // 1 jam dalam detik

    // Gunakan email sebagai kunci di session
    $session_key = 'email_limits_' . md5($email); // md5 untuk menghindari karakter khusus

    // Inisialisasi session jika belum ada untuk email ini
    if (!isset($_SESSION[$session_key])) {
        $_SESSION[$session_key] = [
            'count' => 0,
            'first_time' => time()
        ];
    }

    $limit_data = &$_SESSION[$session_key];

    // Reset hitungan jika waktu jendela sudah lewat
    if (time() - $limit_data['first_time'] > $time_window) {
        $limit_data['count'] = 0;
        $limit_data['first_time'] = time();
    }

    // Cek apakah sudah melebihi batas
    if ($limit_data['count'] >= $max_emails) {
        $_SESSION['notification'] = "Batas pengiriman untuk email ini tercapai. Silakan coba lagi nanti.";
        header('Location: index.php');
        exit();
    }

    return true; // Lanjutkan jika belum melebihi batas
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah field ada sebelum mencoba mengaksesnya
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
    
    // Cek batas pengiriman berdasarkan email
    if (!checkRateLimit($email)) {
        exit(); // Keluar jika batas tercapai
    }

    // Konfigurasi SMTP Mailtrap
    $smtp_host = 'sandbox.smtp.mailtrap.io';
    $smtp_port = 2525;
    $smtp_username = 'b8e05499aa78e5';
    $smtp_password = 'fd2e5dfa5ac1fa';
    
    // Konfigurasi email
    $to = "ariamustofa@gmail.com";
    $subject = "Pesan Baru dari $name - FitLife";
    $body = "Nama: $name\nPhone: $phone\nEmail: $email\nPesan:\n$message";
    
    // Menggunakan PHPMailer untuk mengirim email melalui SMTP Mailtrap
    $mail = new PHPMailer(true);
    
    try {
        // Konfigurasi server
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $smtp_port;
        
        // Penerima
        $mail->setFrom($email, $name);
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);
        
        // Konten
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        $mail->send();
        
        // Tambah hitungan email setelah berhasil dikirim
        $session_key = 'email_limits_' . md5($email);
        $_SESSION[$session_key]['count']++;

        // Simpan notifikasi sukses
        $_SESSION['notification'] = "Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.";
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Simpan notifikasi error
        $_SESSION['notification'] = "Maaf, terjadi kesalahan saat mengirim pesan: " . $mail->ErrorInfo;
        header('Location: index.php');
        exit();
    }
} else {
    // Redirect jika metode tidak valid
    header('Location: index.php');
    exit();
}
?>
