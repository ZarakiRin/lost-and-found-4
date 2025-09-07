<?php
session_start();
require '../conn/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../ManageLost/manage.css">
    <title>Manage Found Items</title>
</head>
<body>
    <div class="container">
        <?php include '../Navbar/navbar.php'; ?>

        <div class="content">

            <!-- Stats Section -->
                <!-- Stats Section -->
                <div class="dashboard-stats">
                    <div class="stat-card card-items">
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <div class="details">
                            <div class="label">Total Items</div>
                            <div class="count">2</div>
                        </div>
                    </div>
                    <div class="stat-card card-claimed">
                        <div class="icon"><i class="fas fa-user-shield"></i></div>
                        <div class="details">
                            <div class="label">Total Claimed</div>
                            <div class="count">1</div>
                        </div>
                    </div>
                    <div class="stat-card card-pending">
                        <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="details">
                            <div class="label">Total Pending</div>
                            <div class="count">1</div>
                        </div>
                    </div>
                </div>


            <!-- Search and Filter (Static for now) -->
            <div class="search-filter">
                <input type="text" placeholder="Search by item name">
                <select>
                    <option value="">Filter by Status</option>
                    <option value="claimed">Claimed</option>
                    <option value="unclaimed">Unclaimed</option>
                </select>
                <select>
                    <option value="">Filter by Category</option>
                    <option value="gadgets">Gadgets</option>
                    <option value="uniform">Uniform</option>
                    <option value="documents">Documents</option>
                </select>
            </div>

            <!-- Found Items Table -->
            <table class="item-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Item Status</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Reported by</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM lost_items ORDER BY date_reported DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0):
                        while($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td>
                                <img src="../<?php echo htmlspecialchars($row['image_url']); ?>" class="item-img" alt="item">
                            </td>
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_reported']); ?></td>
                            <td><?php echo htmlspecialchars($row['reported_by']); ?></td>
                            <td>
                                <button class="btn btn-approve">Approve</button>
                                <button class="btn btn-delete">Delete</button>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr><td colspan="9">No items found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</body>
</html>
