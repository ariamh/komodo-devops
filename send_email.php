<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // Konfigurasi SMTP Mailtrap
    $smtp_host = 'sandbox.smtp.mailtrap.io';
    $smtp_port = 2525; // Dapat menggunakan 25, 465, 587, atau 2525
    $smtp_username = 'b8e05499aa78e5';
    $smtp_password = 'fd2e5dfa5ac1fa';
    
    // Konfigurasi email
    $to = "ariamustofa@gmail.com";
    $subject = "Pesan Baru dari $name - FitLife";
    $body = "Nama: $name\nEmail: $email\nPesan:\n$message";
    $headers = [
        'From' => $email,
        'Reply-To' => $email,
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/plain; charset=utf-8'
    ];
    
    // Menggunakan PHPMailer untuk mengirim email melalui SMTP Mailtrap
    $mail = new PHPMailer(true);
    
    try {
        // Konfigurasi server
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = 'tls'; // Opsional (STARTTLS pada semua port)
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
        // Redirect ke halaman beranda dengan pesan sukses
        // Menggunakan session untuk menyimpan pesan notifikasi
        session_start();
        $_SESSION['notification'] = "Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.";
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Redirect ke halaman beranda dengan pesan error
        session_start();
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