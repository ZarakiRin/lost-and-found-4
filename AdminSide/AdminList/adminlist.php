<?php

// DB connect BEFORE delete handling
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "findmystufflog";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
  die("Connection failed: ".$conn->connect_error);
}

// Handle Delete Request
// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM login WHERE admin_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // **Renumber all IDs and reset AUTO_INCREMENT**
    $conn->query("SET @count = 0");
    $conn->query("UPDATE login SET admin_id = @count:=@count+1 ORDER BY admin_id");
    $conn->query("ALTER TABLE login AUTO_INCREMENT = 1");

    // Redirect to refresh page
    header("Location: adminlist.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Navbar/navbar.css">
  <link rel="stylesheet" href="../AdminList/admin.css">
  <title>Admin List</title>
</head>
<body>
  <div class="container">
    <?php include '../Navbar/navbar.php'; ?>

    <div class="content" id="pageContent">
      <div class="main-wrapper">
        <div class="topbar">
          <h1>Admin Managementtt</h1>
          <div class="right">
            <div class="theme-toggler">
              <span class="material-symbols-outlined active">wb_sunny</span>
              <span class="material-symbols-outlined">dark_mode</span>
            </div>
            <div class="profile">
              <div class="info">
                 <p>Hey, <b><?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : 'Admin'; ?></b></p>
                <small class="text-muted">Admin</small>
              </div>
              <div class="profile-photo">
                <img src="../Images/avatar.svg">
              </div>
            </div>
          </div>
        </div>

        
        <?php
        // -----------------------------
        // Handle Add Admin (fixed)
        // -----------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__add_admin'])) {
            $last_name   = trim($_POST['last_name'] ?? '');
            $first_name  = trim($_POST['first_name'] ?? '');
            $middle_name = trim($_POST['middle_name'] ?? '');
            $faculty_id  = trim($_POST['faculty_id'] ?? '');
            $email       = trim($_POST['email'] ?? '');
            $username    = trim($_POST['username'] ?? '');
            $password    = $_POST['password'] ?? '';

            // basic validation
            if ($last_name !== '' && $faculty_id !== '' && $email !== '' && $username !== '' && $password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // IMPORTANT: include password column in INSERT and match placeholders
                $stmt = $conn->prepare("
                    INSERT INTO login
                    (last_name, first_name, middle_name, faculty_id, email, username, `password`, status, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'inactive', NOW())
                ");

                if (!$stmt) {
                    echo "<div class='alert error'>Prepare failed: " . htmlspecialchars($conn->error) . "</div>";
                } else {
                    // 7 placeholders -> 7 types/variables
                    $stmt->bind_param("sssssss", $last_name, $first_name, $middle_name, $faculty_id, $email, $username, $hash);

                    if ($stmt->execute()) {
                        $stmt->close();
                        header("Location: adminlist.php?added=1");
                        exit;
                    } else {
                        echo "<div class='alert error'>Insert failed: " . htmlspecialchars($stmt->error) . "</div>";
                        $stmt->close();
                    }
                }
            } else {
                echo "<div class='alert error'>Please fill all required fields.</div>";
            }
        }

        // Handle Edit Admin
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id']) && !isset($_POST['__add_admin'])) {
            $id         = intval($_POST['admin_id']);
            $last_name = trim($_POST['last_name'] ?? '');
            $first_name = trim($_POST['first_name'] ?? '');
            $middle_name      = trim($_POST['middle_name'] ?? '');
            $faculty_id  = trim($_POST['faculty_id'] ?? '');
            $email  = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password   = $_POST['password'] ?? '';

            if ($id && $last_name && $first_name && $faculty_id && $email && $username) {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("
                UPDATE login 
                SET last_name=?, first_name=?, middle_name=?, faculty_id=?, email=?, username=?, password=? 
                WHERE admin_id=?
            ");
            $stmt->bind_param("sssssssi", $last_name, $first_name, $middle_name, $faculty_id, $email, $username, $hash, $id);
        } else {
            $stmt = $conn->prepare("
                UPDATE login 
                SET last_name=?, first_name=?, middle_name=?, faculty_id=?, email=?, username=? 
                WHERE admin_id=?
            ");
            $stmt->bind_param("ssssssi", $last_name, $first_name, $middle_name, $faculty_id, $email, $username, $id);
        }

        if ($stmt->execute()) {
            header("Location: adminlist.php?updated=1");
            exit;
        } else {
            echo "<div class='alert error'>Update failed: " . htmlspecialchars($stmt->error) . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert error'>Please fill all required fields.</div>";
    }
}

        // Fetch Admins
        $sql = "SELECT admin_id, last_name, first_name, middle_name, faculty_id, email, username, COALESCE(status,'inactive') AS status, created_at 
                FROM login ORDER BY admin_id DESC";
        $result = $conn->query($sql);

        echo "<div class='header'>";
        echo "<h2>Admin List</h2>";
        echo "<button class='add-btn' id='openModal'> Add Admin</button>";
        echo "</div>";

        if ($result && $result->num_rows > 0) {
          echo "<table>";
          echo "<tr>
                  <th>ID</th>
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Faculty ID</th>
                  <th>Email</th>
                  <th>Username</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>";
          $result = $conn->query("SELECT * FROM login ORDER BY admin_id ASC");
          while ($row = $result->fetch_assoc()) {
            $statusClass = ($row['status'] === 'active') ? "status-active" : "status-inactive";
            $name = preg_replace("/[\r\n]+/", " ", $row['last_name']);

            echo "<tr>";
            echo "<td>".htmlspecialchars($row['admin_id'])."</td>";
            echo "<td>".htmlspecialchars($row['last_name'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($row['first_name'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($row['middle_name'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($row['faculty_id'])."</td>";
            echo "<td>".htmlspecialchars($row['email'])."</td>";
            echo "<td>".htmlspecialchars($row['username'])."</td>";
            echo "<td><span class='$statusClass'>".ucfirst($row['status'])."</span></td>";
            echo "<td>".htmlspecialchars($row['created_at'])."</td>";
      echo "<td class='actions'>";
      echo "<button class='edit-btn'"
        . " data-id='" . htmlspecialchars($row['admin_id']) . "'"
        . " data-last-name='" . htmlspecialchars($row['last_name']) . "'"
        . " data-first-name='" . htmlspecialchars($row['first_name']) . "'"
        . " data-middle-name='" . htmlspecialchars($row['middle_name']) . "'"
        . " data-faculty-id='" . htmlspecialchars($row['faculty_id'] ?? '') . "'"
        . " data-email='" . htmlspecialchars($row['email'] ?? '') . "'"
        . " data-username='" . htmlspecialchars($row['username']) . "'>Edit</button>";
      echo "<form method='GET' action='adminlist.php' style='display:inline;'>";
      echo "<input type='hidden' name='delete_id' value='" . htmlspecialchars($row['admin_id']) . "' />";
      echo "<button type='submit' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this admin?\");'>Delete</button>";
      echo "</form>";
      echo "</td>";
            echo "</tr>";
          }

          echo "</table>";
        } else {
          echo "<h3>No admins found.</h3>";
        }

        $conn->close();
        ?>
      </div>
    </div>
  </div>

   <!--  ADD MODAL POPUP -->
  <div class="modal" id="addAdminModal">
    <div class="modal-content">
      <h2>Add Admin</h2>
      <form action="" method="POST" autocomplete="on">
        <input type="hidden" name="__add_admin" value="1">
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="middle_name" placeholder="Middle Name" required>
        <input type="text" name="faculty_id" placeholder="Faculty ID" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Save</button>
        <button type="button" class="close-btn" id="closeModal">Cancel</button>
      </form>
    </div>
  </div>

  <!--  EDIT MODAL POPUP -->
  <div class="modal" id="editAdminModal">
    <div class="modal-content">
      <h2>Edit Admin</h2>
      <form action="" method="POST" autocomplete="off">
        <input type="hidden" name="admin_id" id="edit_admin_id">
        <input type="text" name="last_name" id="edit_last_name" placeholder="Last Name" required>
        <input type="text" name="first_name" id="edit_first_name" placeholder="First Name" required>
        <input type="text" name="middle_name" id="edit_middle_name" placeholder="Middle Name" required>
        <input type="text" name="faculty_id" id="edit_faculty_id" placeholder="Faculty ID" required>
        <input type="email" name="email" id="edit_email" placeholder="Email" required>
        <input type="text" name="username" id="edit_username" placeholder="Username" required>
        <input type="password" name="password" id="edit_password" placeholder="New Password (leave blank if unchanged)">
        <button type="submit">Update</button>
        <button type="button" class="close-btn" id="closeEditModal">Cancel</button>
      </form>
    </div>
  </div>

  <script src="../AdminList/adminlist.js"></script>
</body>
</html>
