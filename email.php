<?php

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $phone = trim($_POST["phone"] ?? ''); 
    $message = trim($_POST["message"] ?? '');


    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration (Sender)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'sowmiyanallaiyan@gmail.com'; // Your Gmail
        $mail->Password = 'owyi dzhm rrwg kzkn'; // Use App Password (Enable 2FA)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $db_host = "srv673.hstgr.io"; // Usually 'localhost' on Hostinger
        $db_name = "u897560073_form_data";  // Change this
        $db_user = "u897560073_naveen";  // Change this
        $db_pass = "NaveenKumar25"; 
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO contact_form (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':message' => $message
        ]);
        // Sender & Recipient
        $mail->setFrom('sowmiyanallaiyan@gmail.com', 'Maasi Goli soda');
        $mail->addAddress('maasigolisoda@gmail.com', 'Naveen'); // Receiver

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'New Form Submission';
        $mail->Body    = "<h2>New Message from $name</h2>
                          <p><b>Email:</b> $email</p>
                           <p><b>Phone:</b> $phone</p>
                           <p><b>Message:</b> $message</p>";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid Request";
}
?>
