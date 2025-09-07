<?php
session_start();
require '../conn/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginInput = trim($_POST['username']); 
    $password   = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT admin_id, username, email, password, first_name 
        FROM login 
        WHERE username = ? OR email = ?
        LIMIT 1
    ");
    $stmt->bind_param("ss", $loginInput, $loginInput);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();

    if ($user) {
        $dbPassword = $user['password'];
        $isValid = false;

        if (password_verify($password, $dbPassword)) {
            $isValid = true;
        } elseif ($password === $dbPassword) {
            $isValid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE login SET password=? WHERE admin_id=?");
            $update->bind_param("si", $newHash, $user['admin_id']);
            $update->execute();
        }

        if ($isValid) {
            $_SESSION['admin_id']   = $user['admin_id'];
            $_SESSION['first_name'] = $user['first_name'];
            header("Location: ../DashBoard/dashboard.php");
            exit();
        }
    }

    $_SESSION['login_error'] = "Invalid username/email or password";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>

  <link rel="stylesheet" href="../Login/login.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="card">
    <div class="container">
      <div class="img">
        <img src="../Images/LOGO.png" alt="Logo">
      </div>

      <div class="login-content">
        <form action="" method="POST">
          <img src="../Images/avatar.svg" alt="Avatar"/>
          <h2 class="title">WELCOME</h2>

          <?php
          if (isset($_SESSION['login_error'])) {
              echo '<div id="loginError" class="login-error">' . $_SESSION['login_error'] . '</div>';
              unset($_SESSION['login_error']);
          }
          ?>

          <div class="input-div">
            <div class="i"><i class="fas fa-user"></i></div>
            <div class="div">
              <input type="text" class="input" name="username" placeholder=" " required/>
              <h5>Username or Email</h5>
            </div>
          </div>

          <div class="input-div">
            <div class="i"><i class="fas fa-lock"></i></div>
            <div class="div">
              <input type="password" class="input" name="password" id="password" placeholder=" " required/>
              <h5>Password</h5>
            </div>
          </div>

          <div class="show-password">
            <input type="checkbox" id="showPassword">
            <label for="showPassword">Show Password</label>
          </div>

          <a href="../forgotpass/resetpass.php">Forgot Password?</a>
          <input type="submit" class="btn" value="Login"/>
        </form>
      </div>
    </div>
  </div>

  <script src="../Login/login.js"></script>
</body>
</html>
