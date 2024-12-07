<?php
session_start();
include 'db.php';
include 'navbar.php'; // Include the navbar layout

// Check if user is logged in and if they are an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Show an error message and ask the user to log out
    echo "<div class='alert alert-danger'>You need to be an admin to access this page. Please <a href='logout.php'>log out</a> and log back in as an admin.</div>";
    exit();  // Stop further script execution
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Global reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and container */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Navbar */
        .navbar {
            background-color: #2c3e50;
            padding: 15px 30px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: space-between;
        }

        .navbar ul li {
            margin-right: 20px;
        }

        .navbar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        /* Main content */
        header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #34495e;
            text-align: center;
            margin-bottom: 30px;
        }

        main h2 {
            font-size: 1.8rem;
            color: #34495e;
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .actions {
            margin-bottom: 30px;
            display: flex;
            justify-content: flex-start;
        }

        .actions .btn {
            background-color: #3498db;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-right: 15px;
        }

        .actions .btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .actions .btn:active {
            transform: scale(1);
        }

        /* User Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        table th {
            background-color: #2980b9;
            color: #ffffff;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table td {
            background-color: #f9f9f9;
            font-size: 15px;
            color: #555;
        }

        table td a {
            text-decoration: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        table td .btn-warning {
            background-color: #f39c12;
        }

        table td .btn-danger {
            background-color: #e74c3c;
        }

        table td .btn-warning:hover {
            background-color: #e67e22;
        }

        table td .btn-danger:hover {
            background-color: #c0392b;
        }

        table tbody tr:hover {
            background-color: #ecf0f1;
        }

        table tbody tr:nth-child(even) {
            background-color: #f4f6f7;
        }

        table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Alerts */
        .alert {
            margin: 20px 0;
            padding: 15px;
            font-size: 1.2rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background-color: #f2d7d5;
            color: #e74c3c;
        }

        .alert-danger a {
            color: #e74c3c;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin's Dashboard</h1>
        </header>

        <main>
            <h2>User's List</h2>

            <div class="actions">
                <a href="register.php" class="btn">Create New User</a>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
