<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../forgotpass/reset.css">
 
</head>
<body>
  <div class="card">
    <div class="illustration">
      <img src="https://cdn-icons-png.flaticon.com/512/2910/2910768.png" alt="Forgot password illustration" />
    </div>

    <h2>Forgot your password?</h2>
    <p>Enter your email so that we can send you a password reset link</p>
    
    <form id="resetForm">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="e.g. username@gmail.com" required>
      <button type="submit" id="submitBtn">
  <span class="btn-text">Send Email</span>
      <div class="spinner" id="spinner"></div>
    </button>

    </form>

    <div id="responseMessage"></div>

    <a href="../login/login.php" class="back-link">← Back to Login</a>
  </div>

  <script src="../forgotpass/resetpass.js"></script>    
</body>
</html>
