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
      <div class="page-header">
        <div class="page-title">
          <h2>Admin List</h2>
          <p>Manage all registered admins here</p>
        </div>
        <div class="page-actions">
          <button class="export-btn">Export CSV</button>
          <button class="add-btn" id="openModal"> Add Admin</button>
        </div>
      </div>

      <div class="cards-wrapper">
        <div class="card">
          <div class="card-icon" style="background:#ffe2e2; color:#ff6b6b;">
            <span class="material-symbols-outlined">analytics</span>
          </div>
          <div class="card-content">
            <h3>Register Students</h3>
            <p class="card-number">10</p>
            <small>Last 24 Hours</small>
          </div>
        </div>

    <div class="card">
      <div class="card-icon" style="background:#e2f7e6; color:#2ecc71;">
        <span class="material-symbols-outlined">lock</span>
      </div>
      <div class="card-content">
        <h3>Claimed Items</h3>
        <p class="card-number">20</p>
        <small>Last 24 Hours</small>
      </div>
    </div>

    <div class="card">
      <div class="card-icon" style="background:#e2f0ff; color:#3498db;">
        <span class="material-symbols-outlined">mail</span>
      </div>
      <div class="card-content">
        <h3>Responded Message</h3>
        <p class="card-number">10</p>
        <small>Last 24 Hours</small>
      </div>
    </div>
  </div>
        <?php
        // -----------------------------
        // Handle Add Admin
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

                $role = $_POST['role'] ?? 'user'; // default user if not set

                $stmt = $conn->prepare("
                    INSERT INTO login
                    (last_name, first_name, middle_name, faculty_id, email, username, role, `password`, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                $stmt->bind_param("ssssssss", $last_name, $first_name, $middle_name, $faculty_id, $email, $username, $role, $hash);


                if (!$stmt) {
                    echo "<div class='alert error'>Prepare failed: " . htmlspecialchars($conn->error) . "</div>";
                } else {
                    $stmt->bind_param("ssssssss", $last_name, $first_name, $middle_name, $faculty_id, $email, $username, $role, $hash);

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
            $role       = $_POST['role'] ?? 'user'; // 
            $password   = $_POST['password'] ?? '';

            if ($id && $last_name && $first_name && $faculty_id && $email && $username) {
                if (!empty($password)) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("
                        UPDATE login 
                        SET last_name=?, first_name=?, middle_name=?, faculty_id=?, email=?, username=?, role=?, password=? 
                        WHERE admin_id=?
                    ");
                    $stmt->bind_param("ssssssi", $last_name, $first_name, $middle_name, $faculty_id, $email, $username, $role, $hash, $id);
                } else {
                    $stmt = $conn->prepare("
                        UPDATE login 
                        SET last_name=?, first_name=?, middle_name=?, faculty_id=?, email=?, username=?, role=?
                        WHERE admin_id=?
                    ");
                    $stmt->bind_param("sssssssi", $last_name, $first_name, $middle_name, $faculty_id, $email, $username, $role, $id);
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

        // Fetch Admins (use role instead of status)
        $sql = "SELECT admin_id, last_name, first_name, middle_name, faculty_id, email, username, role, created_at 
                FROM login ORDER BY admin_id DESC";
        $result = $conn->query($sql);

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
                  <th>Role</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>";
          $result = $conn->query("SELECT * FROM login ORDER BY admin_id ASC");
          while ($row = $result->fetch_assoc()) {
            $roleClass = ($row['role'] === 'active') ? "status-active" : "status-inactive";
            $name = preg_replace("/[\r\n]+/", " ", $row['last_name']);

            echo "<tr>";
            echo "<td>".htmlspecialchars($row['admin_id'])."</td>";
            echo "<td>".htmlspecialchars($row['last_name'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($row['first_name'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($row['middle_name'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($row['faculty_id'])."</td>";
            echo "<td>".htmlspecialchars($row['email'])."</td>";
            echo "<td>".htmlspecialchars($row['username'])."</td>";
            echo "<td><span class='$roleClass'>".ucfirst($row['role'])."</span></td>";
            echo "<td>".htmlspecialchars($row['created_at'])."</td>";
            echo "<td class='actions'>";
            echo "<button class='edit-btn'"
          . " data-id='" . htmlspecialchars($row['admin_id']) . "'"
          . " data-last-name='" . htmlspecialchars($row['last_name']) . "'"
          . " data-first-name='" . htmlspecialchars($row['first_name']) . "'"
          . " data-middle-name='" . htmlspecialchars($row['middle_name']) . "'"
          . " data-faculty-id='" . htmlspecialchars($row['faculty_id'] ?? '') . "'"
          . " data-email='" . htmlspecialchars($row['email'] ?? '') . "'"
          . " data-username='" . htmlspecialchars($row['username']) . "'"
          . " data-role='" . htmlspecialchars($row['role']) . "'>Edit</button>";

            echo "<form method='GET' action='adminlist.php' style='display:inline;' class='delete-form'>";
            echo "<input type='hidden' name='delete_id' value='" . htmlspecialchars($row['admin_id']) . "' />";
            echo "<button type='button' class='delete-btn'>Delete</button>";
            echo "</form>";

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
      <h2>Add Userr</h2>
      <form action="" method="POST" autocomplete="on">
        <input type="hidden" name="__add_admin" value="1">
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="middle_name" placeholder="Middle Name" required>
        <input type="text" name="faculty_id" placeholder="Faculty ID" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
         <label for="role">Role:</label>
      <select name="role" id="role" required>
        <option value="" disabled selected>Select role</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
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

          <label for="edit_role">Role:</label>
        <select name="role" id="edit_role" required>
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>


        <input type="password" name="password" id="edit_password" placeholder="New Password (leave blank if unchanged)">
        <button type="submit">Update</button>
        <button type="button" class="close-btn" id="closeEditModal">Cancel</button>
      </form>
    </div>
  </div>

  <script src="../AdminList/adminlist.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
