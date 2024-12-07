<?php
include 'db.php';

$message = '';  // Initialize the message variable

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$passwordHash', '$role')";
    if ($conn->query($sql) === TRUE) {
        // Success message
        $message = "<p>User registered successfully!</p>";
    } else {
        // Error message
        $message = "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            background: linear-gradient(to bottom right, #ff7e5f, #feb47b); /* Soft gradient background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .register-container:hover {
            transform: scale(1.03);
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 18px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background-color: #f7f7f7;
        }

        input:focus, select:focus {
            border-color: #ff7e5f;
            background-color: #fff;
        }

        button {
            width: 100%;
            padding: 18px;
            background-color: #ff7e5f;
            border: none;
            color: white;
            font-size: 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #feb47b;
            transform: scale(1.05);
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

        .message-box {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #333;
        }

        .message-box.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register New User</h2>
        
        <!-- Display success or error message if any -->
        <?php if ($message) : ?>
            <div class="message-box <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="register" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
