<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "findmystufflog");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $query = "SELECT * FROM login WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(32));
        $token_hash = password_hash($token, PASSWORD_DEFAULT);
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $update = "UPDATE login SET reset_token_hash = '$token_hash', reset_expires_at = '$expires' WHERE email = '$email'";
        if ($conn->query($update)) {
          $resetLink = "http://localhost/adminside/lost-and-found-4/AdminSide/forgotpass/linkreset.php?email=" 
            . urlencode($email) . "&token=$token";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rosayassine6@gmail.com';  // 🔁 Replace
                $mail->Password = 'miglozifjfpleznc';          // 🔁 Replace
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('yourrealgmail@gmail.com', 'FindMyStuff');
                $mail->addAddress($email, $user['first_name']);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "
                    <p>Hi <strong>{$user['first_name']}</strong>,</p>
                    <p>Click the button below to reset your password:</p>
                    <p><a href='$resetLink' style='background-color: #4CAF50; padding: 10px 20px; color: white; text-decoration: none;'>Reset Password</a></p>
                    <p>If you didn't request this, ignore this email. The link expires in 1 hour.</p>
                ";
                $mail->AltBody = "Reset link: $resetLink";

                $mail->send();

                echo json_encode([
                    'success' => true,
                    'message' => "A password reset link has been sent to <strong>$email</strong>."
                ]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update token in database.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No account found with that email.']);
    }
}
?>
