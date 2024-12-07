<?php
    include 'db.php';

    if (isset($_POST['backup'])) {
        $backupFile = 'backups/backup_' . date('Y-m-d_H-i-s') . '.tar.gz';

        // Command to backup files
        $command = "tar -czf $backupFile uploads/";
        exec($command);

        echo "<p>Backup created successfully!</p>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup Files</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Backup System</h2>
        <form action="backup.php" method="POST">
            <button type="submit" name="backup" class="btn">Create Backup</button>
        </form>
    </div>
</body>
</html>
