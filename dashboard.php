<?php
// Start session
session_start();
include 'navbar.php';  // Include the centralized navbar

// Check if the user is logged in by checking if 'username' session variable is set
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // If user is not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Header Styles */
        header {
            background-color: #0d2538;
            color: #ffffff;
            padding: 30px 0;
            border-bottom: 4px solid #3b82f6;
        }

        header h1 {
            margin: 0;
            font-size: 2.8em;
            letter-spacing: 1px;
        }

        /* Main Content Styles */
        main {
            margin: 50px auto;
            width: 85%;
            max-width: 900px;
            color: #333;
            font-size: 1.3em;
        }

        main h2 {
            color: #444;
            font-size: 1.6em;
            margin-bottom: 30px;
        }

        /* Button Link Styling */
        .redirect-btn {
            display: inline-block;
            padding: 18px 40px;
            background-color: #3b82f6;
            color: white;
            font-size: 1.3em;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Hover effect */
        .redirect-btn:hover {
            background-color: #2563eb;
            transform: translateY(-4px);
        }

        /* Button active state */
        .redirect-btn:active {
            background-color: #1d4ed8;
            transform: translateY(2px);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2.2em;
            }

            main h2 {
                font-size: 1.4em;
            }

            .redirect-btn {
                width: 100%;
                font-size: 1.2em;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        
    </header>

    <main>
    <h1>HELLO, <?php echo htmlspecialchars($username); ?>!</h1>
        <h2>Welcome to  NAS server!!!!!</h2>
        
        
    </main>

</body>
</html>
