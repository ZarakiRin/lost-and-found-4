
<?php
session_start();
$adminFirstName = isset($_SESSION['admin_firstname']) ? $_SESSION['admin_firstname'] : 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../DashBoard/dashboard.css">
    <link rel="stylesheet" href="../Navbar/navbar.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Home</title>
</head>
<body>
    <div class="container">
      <?php include '../Navbar/navbar.php'; ?>


        <main>
            <h1>Dashboard</h1>

            <div class="date">
                <input type="date">

            </div>

            <div class="insights">
                <div class="Lost">
                    <span class="material-symbols-outlined">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Register Students</h3>
                            <h1>10</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy = '38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>59%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>

                <div class="claimed">
                    <span class="material-symbols-outlined">
                    personal_bag
                    </span>
                    <div class="middle">
                        <div class="left">
                            <h3>Claimed Items</h3>
                            <h1>20</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy = '38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>40%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>

                <div class="respond">
                    <span class="material-symbols-outlined">
                    drafts
                    </span>
                    <div class="middle">
                        <div class="left">
                            <h3>Responded Message</h3>
                            <h1>10</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy = '38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>79%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 Hours</small>
                </div>


            </div>

            <div class="recent-updates">
                <h2>Recent Lost Item</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Report Id</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nike Shoes</td>
                            <td>00001</td>
                            <td>Shoes</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Student Id</td>
                            <td>00002</td>
                            <td>Personal Information</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Cellphone</td>
                            <td>00003</td>
                            <td>Gadgets</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Laptop</td>
                            <td>00004</td>
                            <td>Gadgets</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Tumbler</td>
                            <td>00005</td>
                            <td>Belongings</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Nike Shoes</td>
                            <td>00006</td>
                            <td>Shoes</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Nike Shoes</td>
                            <td>00006</td>
                            <td>Shoes</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Nike Shoes</td>
                            <td>00006</td>
                            <td>Shoes</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>Nike Shoes</td>
                            <td>00006</td>
                            <td>Shoes</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                </table>
                <a href="#">Show All</a>
            </div>
        </main>

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-symbols-outlined">
                filter_list
                </span>
                </button>
                <div class="theme-toggler">
                    <span class="material-symbols-outlined active" >
                wb_sunny
                </span>
                    <span class="material-symbols-outlined">
                    dark_mode
                    </span>
                </div>
                <div class="profile">
                    <div class="info">
                         <p>Hey, <b><?php echo !empty($adminFirstName) && strtolower($adminFirstName) !== 'admin' ? htmlspecialchars($adminFirstName) : 'Your Name'; ?></b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../Images/avatar.svg">
                    </div>
                </div>
            </div>

            <div class="recent-updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="../Images/undraw_avatar-traveler_ljy2.svg">
                        </div>
                        <div class="message">
                            <p><b>Mark Aldrin</b> reported an Lost Item</p>
                            <small class="text-muted">1 mins ago</small>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="../Images/undraw_a-woman-avatar_ifsl.svg">
                        </div>
                        <div class="message">
                            <p><b>Mark Aldrin</b> reported an Lost Item</p>
                            <small class="text-muted">2 mins ago</small>
                        </div>
                    </div>
                    <div class="update">
                        <div class="profile-photo">
                            <img src="../Images/undraw_female-avatar_7t6k.svg">
                        </div>
                        <div class="message">
                            <p><b>Mark Aldrin</b> reported an Lost Item</p>
                            <small class="text-muted">2 mins ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lost-analytics">
    <h2>Lost Item Analytics</h2>

    <div class="analytics-card">
        <div class="icon blue">
            <span class="material-symbols-outlined">shoppingmode</span>
        </div>
        <div class="details">
            <h3>CLAIM RATE</h3>
            <small>Last 24 Hours</small>
        </div>
        <div class="stats">
            <h5 class="success">+39%</h5>
            <h3>200</h3>
        </div>
    </div>

    <div class="analytics-card">
        <div class="icon red">
            <span class="material-symbols-outlined">backpack</span>
        </div>
        <div class="details">
            <h3>LOST ITEM REPORTS</h3>
            <small>Last 24 Hours</small>
        </div>
        <div class="stats">
            <h5 class="danger">-17%</h5>
            <h3>120</h3>
        </div>
    </div>

    <div class="analytics-card">
        <div class="icon green">
            <span class="material-symbols-outlined">person_add</span>
        </div>
        <div class="details">
            <h3>NEW CLAIMANTS</h3>
            <small>Last 24 Hours</small>
        </div>
        <div class="stats">
            <h5 class="success">+25%</h5>
            <h3>45</h3>
        </div>
    </div>
</div>


            

           
            
        </div>
    </div>
</div>
</body>
</html>