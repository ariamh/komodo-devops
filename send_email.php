<?php
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
    $to = "ariamustofa@gmail.com"; // Ganti dengan email tujuan
    $subject = "Pesan Baru dari $name - FitLife";
    $body = "Nama: $name\nEmail: $email\nPesan:\n$message";
    $headers = [
        'From' => $email,
        'Reply-To' => $email,
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/plain; charset=utf-8'
    ];
    
    // Menggunakan PHPMailer untuk mengirim email melalui SMTP Mailtrap
    require 'vendor/autoload.php'; // Pastikan PHPMailer sudah diinstall via Composer
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
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
        echo "<p>Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.</p>";
    } catch (Exception $e) {
        echo "<p>Maaf, terjadi kesalahan saat mengirim pesan: {$mail->ErrorInfo}</p>";
    }
} else {
    echo "<p>Metode pengiriman tidak valid.</p>";
}
?>
