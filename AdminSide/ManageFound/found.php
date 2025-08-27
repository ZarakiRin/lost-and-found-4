<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../ManageFound/found.css">
    <title>Manage Found Items</title>
</head>
<body>
    <div class="container">
     <?php include '../Navbar/navbar.php'; ?>
        <div class="content">

        <!-- Stats Section -->
        <div class="stats">
            <div class="stat-card">Total Found: 15</div>
            <div class="stat-card">Claimed: 7</div>
            <div class="stat-card">Unclaimed: 8</div>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter">
            <input type="text" placeholder="Search by item name or claimant">
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
                    <th>Date Found</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Claimant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="../Images/id3.jpg"  class="item-img" alt="item"></td>
                    <td>Blue ID</td>
                    <td>Student ID, name partially visible</td>
                    <td>2025-08-20</td>
                    <td>Cafeteria</td>
                    <td>Unclaimed</td>
                    <td>-</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                        <button class="btn btn-claim">Mark as Claimed</button>
                    </td>
                </tr>
                <tr>
                    <td><img src="../Images/wallet.png" class="item-img" alt="item"></td>
                    <td>Black Wallet</td>
                    <td>Leather, with school logo</td>
                    <td>2025-08-18</td>
                    <td>Library</td>
                    <td>Claimed</td>
                    <td>Juan Dela Cruz</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
        
    </div>
</body>
</html>
