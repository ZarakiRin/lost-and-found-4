<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Navbar/navbar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>navbar</title>
</head>
<style>

    
</style>
<body>

    <?php
// Get the current file name without folder path or query params
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<div class="container">
    <aside>
        <div class="top">
            <div class="logo">
                <img src="../Images/LOGO.png">
                <h2>Iba National HighSchool</h2>
            </div>
            <div class="close" id="close-btn">
                <span class="material-symbols-outlined">close</span>
            </div>
        </div>

        <div class="sidebar">
            <a href="../DashBoard/dashboard.php" class="<?= $current_page === 'dashboard.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">space_dashboard</span>
                <h3>Dashboard</h3>
            </a>

            <a href="../ManageFound/found.php" class="<?= $current_page === 'found.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">cases</span>
                <h3>Manage Found Items</h3>
            </a>

            <a href="../PageContent/lostreports/lostreports.php" class="<?= $current_page === 'lostreports.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">feature_search</span>
                <h3>Manage Lost Reports</h3>
            </a>

            <a href="../PageContent/claimrequest/claimrequest.php" class="<?= $current_page === 'claimrequest.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">input</span>
                <h3>Claim Request</h3>
            </a>

            <a href="../PageContent/returneditems/returneditems.php" class="<?= $current_page === 'returneditems.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">check_box</span>
                <h3>Returned Items</h3>
            </a>

            <a href="../Adminlist/adminlist.php" class="<?= $current_page === 'adminlist.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <h3>User List</h3>
            </a>

            <a href="../Messages/message.php" class="<?= $current_page === 'message.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">chat_bubble</span>
                <h3>Messages</h3>
                <span class="message-count">26</span>
            </a>

            <a href="../Notifications/notifications.php" class="<?= $current_page === 'notifications.php' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">notifications</span>
                <h3>Notification</h3>
            </a>

            <a href="../Logout/logout.php">
                <span class="material-symbols-outlined">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>
</div>

</body>
</html>