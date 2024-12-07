<?php
session_start(); // Start session if not already started
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Navbar styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #004d7a;
            padding: 15px 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar ul li {
            margin-right: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar ul li a:hover {
            background-color: #003c5e;
            text-decoration: none;
        }

        .navbar .logout {
            margin-left: auto;
        }

        .navbar .logout a {
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar .logout a:hover {
            background-color: #003c5e;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="files.php">File Management</a></li>
            <li><a href="users.php">User Management</a></li>
            <li><a href="monitoring.php">System Monitoring</a></li>
            <li><a href="backup.php">Backup & Restore</a></li>
        </ul>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </nav>
</body>
</html>
