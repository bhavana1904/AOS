<?php
// Including the navbar
include 'navbar.php';

// Get disk usage in GB
$disk_total_space = disk_total_space("/");
$disk_free_space = disk_free_space("/");
$disk_used_space = $disk_total_space - $disk_free_space;
$disk_used_gb = number_format($disk_used_space / (1024 ** 3), 2); // Convert to GB
$disk_free_gb = number_format($disk_free_space / (1024 ** 3), 2); // Convert to GB

// Get CPU usage in percentage
$cpu_usage = sys_getloadavg()[0]; // 1-minute load average

// Fetch system logs (limiting to avoid large output)
$logs = file_get_contents('/var/log/syslog');
$logs_preview = substr($logs, 0, 1000); // Preview first 1000 characters for better readability
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Monitoring</title>
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background-color: #34495e;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            color: #f39c12;
        }

        .system-stats {
            background-color: #1f2a36;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .system-stats p {
            font-size: 18px;
            margin: 15px 0;
            color: #bdc3c7;
        }

        .system-stats pre {
            background-color: #2c3e50;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
            color: #ecf0f1;
            border: 1px solid #444;
        }

        /* Add some responsive design */
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            h2 {
                font-size: 28px;
            }

            .system-stats p {
                font-size: 16px;
            }

            .system-stats pre {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>System Monitoring</h2>

        <div class="system-stats">
            <p><strong>Disk Usage:</strong> <?php echo $disk_used_gb; ?> GB used and <?php echo $disk_free_gb; ?> GB available</p>
            <p><strong>CPU Usage:</strong> <?php echo number_format($cpu_usage, 2); ?>% (1-minute load average)</p>
            <p><strong>Logs:</strong></p>
            <pre><?php echo htmlspecialchars($logs_preview); ?></pre>
        </div>
    </div>
</body>
</html>
