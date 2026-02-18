<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail_to = trim($_POST["doctorEmail"]);
    $doctor_name = trim($_POST["doctorName"]);
    $doctor_speciality = trim($_POST["doctorSpeciality"]);
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $date = trim($_POST["date"]);
    $time = trim($_POST["time"]);
    $message = trim($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // Gmail SMTP setup
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your@gmail.com'; // your Gmail
        $mail->Password = 'YOUR_APP_PASSWORD'; // your 16-character app password (no spaces)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // From & To
        $mail->setFrom('your@gmail.com', 'Healthcare Finder');
        $mail->addAddress($mail_to, $doctor_name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Appointment Request for $doctor_name";
        $mail->Body = "
            <h3>New Appointment Request</h3>
            <p><strong>Doctor:</strong> $doctor_name ($doctor_speciality)</p>
            <p><strong>Patient:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Date:</strong> $date</p>
            <p><strong>Time:</strong> $time</p>
            <p><strong>Message:</strong> $message</p>
        ";

        $mail->send();
        header("Location: confirmation.html");
        exit;
    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?> 
