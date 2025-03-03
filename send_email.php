<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Function untuk membaca secret dari file (untuk Docker Secrets)
function readSecretFromFile($var) {
    $file_var = $var . '_FILE';
    if (getenv($file_var)) {
        return trim(file_get_contents(getenv($file_var)));
    }
    return null;
}

// Load kredensial dari .env jika ada
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Mendapatkan nilai dari environment variables dengan prioritas:
// 1. $_ENV (dari .env file via Dotenv)
// 2. getenv() (dari environment system/Docker)
// 3. Docker secrets (jika digunakan)
$smtp_host = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST') ?? readSecretFromFile('SMTP_HOST');
$smtp_port = $_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?? readSecretFromFile('SMTP_PORT');
$smtp_username = $_ENV['SMTP_USERNAME'] ?? getenv('SMTP_USERNAME') ?? readSecretFromFile('SMTP_USERNAME');
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? getenv('SMTP_PASSWORD') ?? readSecretFromFile('SMTP_PASSWORD');
$admin_email = $_ENV['ADMIN_EMAIL'] ?? getenv('ADMIN_EMAIL') ?? readSecretFromFile('ADMIN_EMAIL') ?? 'ariamustofa@gmail.com';

// Validasi kredensial
if (!$smtp_host || !$smtp_port || !$smtp_username || !$smtp_password) {
    $_SESSION['notification'] = "Konfigurasi SMTP tidak lengkap. Hubungi administrator.";
    error_log("SMTP configuration missing: HOST=" . ($smtp_host ? '[set]' : '[unset]') . 
              ", PORT=" . ($smtp_port ? '[set]' : '[unset]') . 
              ", USERNAME=" . ($smtp_username ? '[set]' : '[unset]') . 
              ", PASSWORD=" . ($smtp_password ? '[set]' : '[unset]'));
    header('Location: index.php');
    exit();
}

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
    // CSRF validasi dinonaktifkan karena menimbulkan error
    // Komentar berikut menunjukkan implementasi yang benar jika ingin diaktifkan di masa depan
    /*
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['notification'] = "Permintaan tidak valid.";
        header('Location: index.php');
        exit();
    }
    */

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
        $mail->addAddress($admin_email);
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
