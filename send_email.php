<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Inisialisasi CSRF token jika belum ada
// if (!isset($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// }

// Load kredensial dari .env
try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    error_log("Dotenv Error: " . $e->getMessage());
    $_SESSION['notification'] = "Konfigurasi server bermasalah.";
    header('Location: index.php');
    exit();
}

$smtp_host = $_ENV['SMTP_HOST'] ?? 'sandbox.smtp.mailtrap.io';
$smtp_port = $_ENV['SMTP_PORT'] ?? 2525;
$smtp_username = $_ENV['SMTP_USERNAME'] ?? 'b8e05499aa78e5';
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? 'fd2e5dfa5ac1fa';

function checkRateLimit($email) {
    $max_emails = 3;
    $time_window = 3600;
    $ip = $_SERVER['REMOTE_ADDR'];
    $session_key = 'email_limits_' . md5($email . $ip);

    if (!isset($_SESSION[$session_key])) {
        $_SESSION[$session_key] = ['count' => 0, 'first_time' => time()];
    }

    $limit_data = &$_SESSION[$session_key];
    if (time() - $limit_data['first_time'] > $time_window) {
        $limit_data['count'] = 0;
        $limit_data['first_time'] = time();
    }

    if ($limit_data['count'] >= $max_emails) {
        $_SESSION['notification'] = "Batas pengiriman tercapai.";
        header('Location: index.php');
        exit();
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi CSRF
    // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    //     $_SESSION['notification'] = "Permintaan tidak valid.";
    //     header('Location: index.php');
    //     exit();
    // }

    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Validasi input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['notification'] = "Format email tidak valid.";
        header('Location: index.php');
        exit();
    }

    if (!preg_match('/^[0-9+\-\s]{8,15}$/', $phone)) {
        $_SESSION['notification'] = "Nomor telepon tidak valid.";
        header('Location: index.php');
        exit();
    }

    if (strlen($name) > 15 || strlen($message) > 50) {
        $_SESSION['notification'] = "Nama atau pesan terlalu panjang.";
        header('Location: index.php');
        exit();
    }

    if (!checkRateLimit($email)) {
        exit();
    }

    $to = "ariamustofa@gmail.com";
    $subject = "Pesan Baru dari $name - FitLife";
    $body = "Nama: $name\nPhone: $phone\nEmail: $email\nPesan:\n$message";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $smtp_port;

        $mail->setFrom('no-reply@fitlife.com', 'FitLife Personal Training');
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();

        $session_key = 'email_limits_' . md5($email . $_SERVER['REMOTE_ADDR']);
        $_SESSION[$session_key]['count']++;
        session_regenerate_id(true);

        $_SESSION['notification'] = "Pesan Anda berhasil dikirim!";
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['notification'] = "Maaf, terjadi kesalahan saat mengirim pesan.";
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
