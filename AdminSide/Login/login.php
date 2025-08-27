<?php
session_start();
require '../conn/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT admin_id, username, password, first_name FROM login WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  // Plain text comparison
  if ($user && $password === $user['password']) {
    $_SESSION['admin_id'] = $user['admin_id'];
    $_SESSION['first_name'] = $user['first_name'];
    header("Location: ../DashBoard/dashboard.php");
    exit();
  } else {
    echo "Invalid credentials";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../Login/login.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <title>Login</title>
</head>
<body>
  <div class="card">
    <div class="container">
      <div class="img">
        <img src="../Images/LOGO.png" alt="Left Illustration">
      </div>

      <div class="login-content">
        <!-- The form posts back to the same file -->
        <form action="" method="POST">
          <img src="../Images/avatar.svg" alt="Avatar" />
          <h2 class="title">WELCOME</h2>

          <?php
          if (isset($_SESSION['login_error'])) {
              echo '<p style="color:red; text-align:center;">' . $_SESSION['login_error'] . '</p>';
              unset($_SESSION['login_error']);
          }
          ?>

          <div class="input-div one">
            <div class="i">
              <i class="fas fa-user"></i>
            </div>
            <div class="div">
              <input type="text" class="input" name="username" placeholder=" " required />
              <h5>Username</h5>
            </div>
          </div>

          <div class="input-div pass">
            <div class="i">
              <i class="fas fa-lock"></i>
            </div>
            <div class="div">
              <input type="password" class="input" name="password" id="password" placeholder=" " required />
              <h5>Password</h5>
              <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye"></i>
              </span>
            </div>
          </div>

          <a href="#">Forgot Password?</a>
          <input type="submit" class="btn" value="Login" />
        </form>
      </div>
    </div>
  </div>
</body>
</html>
