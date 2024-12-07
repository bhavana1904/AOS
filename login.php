<?php
include 'db.php';

session_start();

$error_message = '';  // Variable to store error message

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to find the user by username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Set the error message if credentials are invalid
        $error_message = 'Invalid credentials. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff; /* Light background color */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            background-color: #fff0f0; /* Light pink background color for the container */
            padding: 50px; /* Increased padding for a larger form */
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px; /* Increased max-width for a larger container */
            text-align: center;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: scale(1.03);
        }

        h2 {
            font-size: 2.8rem; /* Slightly increased font size */
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 16px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background-color: #f7f7f7;
        }

        input:focus {
            border-color: #ff7e5f;
            background-color: #fff;
        }

        /* Updated button styles */
        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(45deg, #ff7e5f, #feb47b); /* Gradient color */
            border: none;
            color: white;
            font-size: 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: linear-gradient(45deg, #feb47b, #ff7e5f); /* Reverse gradient on hover */
            transform: scale(1.05);
        }

        button:active {
            transform: scale(1.02); /* Slightly shrink the button when clicked */
        }

        p {
            font-size: 1.1rem;
            color: #555;
            margin-top: 20px;
        }

        a {
            color: #ff7e5f;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Page</h2>
        <form action="login.php" method="POST">
            
            <!-- Display error message inside the form if there is one -->
            <?php if ($error_message): ?>
                <div class="error-message">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
