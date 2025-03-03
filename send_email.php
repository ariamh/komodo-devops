<?php
session_start();

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah field ada sebelum mencoba mengaksesnya
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
    
    // Konfigurasi SMTP Mailtrap
    $smtp_host = 'sandbox.smtp.mailtrap.io';
    $smtp_port = 2525;
    $smtp_username = 'b8e05499aa78e5';
    $smtp_password = 'fd2e5dfa5ac1fa';
    
    // Konfigurasi email
    $to = "ariamustofa@gmail.com";
    $subject = "Pesan Baru dari $name - FitLife";
    $body = "Nama: $name\nPhone: $phone\nEmail: $email\nPesan:\n$message";
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
