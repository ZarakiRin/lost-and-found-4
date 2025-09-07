<?php
$conn = new mysqli("localhost", "root", "", "findmystufflog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showForm = false;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $email = $_POST['email'] ?? '';
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($email && $token) {
        if ($password === $confirm) {
            // Fetch token details
            $stmt = $conn->prepare("SELECT reset_token_hash, reset_expires_at FROM login WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($token, $user['reset_token_hash']) && strtotime($user['reset_expires_at']) > time()) {
                    // Hash new password
                    $newPassword = password_hash($password, PASSWORD_DEFAULT);

                    $update = $conn->prepare("UPDATE login 
                        SET password=?, reset_token_hash=NULL, reset_expires_at=NULL 
                        WHERE email=?");
                    $update->bind_param("ss", $newPassword, $email);

                    if ($update->execute()) {
                        $success = "✅ Password updated successfully! You may now login.";
                    } else {
                        $error = "Failed to update password.";
                    }
                } else {
                    $error = "Invalid or expired token.";
                }
            } else {
                $error = "Invalid request.";
            }
        } else {
            $error = "Passwords do not match.";
        }
    } else {
        $error = "Missing email or token.";
    }
} else {
    // Handle GET request (show form)
    $email = $_GET['email'] ?? '';
    $token = $_GET['token'] ?? '';

    if ($email && $token) {
        $stmt = $conn->prepare("SELECT reset_token_hash, reset_expires_at FROM login WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($token, $user['reset_token_hash']) && strtotime($user['reset_expires_at']) > time()) {
                $showForm = true;
            } else {
                $error = "Invalid or expired token.";
            }
        } else {
            $error = "Invalid email or token.";
        }
    } else {
        $error = "Missing email or token.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="../forgotpass/link.css"> <!-- optional -->
</head>
<body>
  <div class="card">
    <?php if ($success): ?>
      <h2>Success</h2>
      <p><?= $success ?></p>
      <a href="../Login/login.php">Go to Login</a>
    <?php elseif ($showForm): ?>
      <h2>Reset Your Password</h2>
      <form method="POST" action="linkreset.php">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">New Password</label>
        <input type="password" name="password" id="password" required minlength="6">

        <label for="confirm_password">Confirm New Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required minlength="6">

        <button type="submit">Reset Password</button>
      </form>
    <?php else: ?>
      <h2>Error</h2>
      <p><?= $error ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
