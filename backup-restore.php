<?php
// Check if backup or restore request was made
if (isset($_POST['backup'])) {
    // Define the directory to be backed up (example directory)
    $backupDirectory = "/path/to/your/directory"; // Replace with the directory you want to back up
    $backupFile = 'uploads/backup_' . date('Y-m-d_H-i-s') . '.tar.gz';

    // Command to create backup (tar.gz compression)
    $backupCommand = "sudo tar -czf $backupFile $backupDirectory";
    
    // Execute the backup command
    exec($backupCommand, $output, $status);

    if ($status === 0) {
        echo "<p>Backup created successfully: <a href='$backupFile'>Download Backup</a></p>";
    } else {
        echo "<p>Error creating backup. Please check the server logs.</p>";
    }
}

if (isset($_POST['restore'])) {
    // Check if file was uploaded
    if (isset($_FILES['backupFile']) && $_FILES['backupFile']['error'] == 0) {
        $backupFile = $_FILES['backupFile']['tmp_name'];

        // Check file type (tar.gz)
        $fileExtension = pathinfo($_FILES['backupFile']['name'], PATHINFO_EXTENSION);
        if ($fileExtension === 'gz') {
            $restoreDirectory = 'uploads/'; // Directory to restore to

            // Sanitize file name
            $sanitizedFileName = basename($_FILES['backupFile']['name']);

            // Command to restore files
            $restoreCommand = "sudo tar -xzf $backupFile -C $restoreDirectory/";

            // Execute the restore command
            exec($restoreCommand, $output, $status);

            if ($status === 0) {
                echo "<p>Backup restored successfully!</p>";
            } else {
                echo "<p>Error restoring backup. Please check the server logs.</p>";
            }
        } else {
            echo "<p>Invalid file type. Please upload a .tar.gz file.</p>";
        }
    } else {
        echo "<p>No file uploaded or error during upload. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9fafb;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 36px;
            color: #3498db;
            text-align: center;
            margin-bottom: 40px;
        }

        .action-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .action-box {
            background-color: #ecf0f1;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 48%;
            box-sizing: border-box;
            text-align: center;
        }

        .action-box h3 {
            font-size: 28px;
            color: #34495e;
            margin-bottom: 20px;
        }

        .action-box p {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #3498db;
            color: white;
            font-size: 18px;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        input[type="file"] {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            width: 100%;
            font-size: 16px;
            background-color: #fff;
        }

        label {
            display: block;
            font-size: 18px;
            color: #34495e;
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .action-container {
                flex-direction: column;
                align-items: center;
            }

            .action-box {
                width: 100%;
                margin-bottom: 20px;
            }

            h2 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Backup and Restore System</h2>

        <div class="action-container">
            <!-- Backup Section -->
            <div class="action-box">
                <h3>Create Backup</h3>
                <p>Create a backup of your files and system configurations.</p>
                <form method="post" action="" enctype="multipart/form-data">
                    <button type="submit" name="backup" class="btn">Create Backup</button>
                </form>
            </div>

            <!-- Restore Section -->
            <div class="action-box">
                <h3>Restore Backup</h3>
                <p>Restore files from a previous backup.</p>
                <form method="post" action="" enctype="multipart/form-data">
                    <label for="backup_file">Choose a Backup:</label>
                    <input type="file" name="backupFile" id="backup_file" required>
                    <button type="submit" name="restore" class="btn">Restore Backup</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
