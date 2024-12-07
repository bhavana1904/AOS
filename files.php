<?php
    include 'db.php';
    session_start();
    include 'navbar.php';  // Include the centralized navbar

    // Upload File
    if (isset($_POST['upload'])) {
        $file = $_FILES['fileToUpload'];
        $filename = $_FILES['fileToUpload']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($filename);

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            if (isset($_SESSION['user_id'])) {
                $uploaded_by = $_SESSION['user_id'];
            } else {
                echo "<p>You need to be logged in to upload a file.</p>";
                exit();
            }

            $sql = "INSERT INTO files (filename, filepath, uploaded_by) VALUES ('$filename', '$target_file', '$uploaded_by')";
            if ($conn->query($sql) === TRUE) {
                header("Location: files.php");
                exit();
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error uploading file. Please try again.</p>";
        }
    }

    // Create Folder
    if (isset($_POST['create_folder'])) {
        $folder_name = $_POST['folder_name'];
        $folder_path = "uploads/" . $folder_name;

        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, true);
            echo "<p>Folder '$folder_name' created successfully.</p>";
        } else {
            echo "<p>Folder already exists.</p>";
        }
    }

    // Rename Folder
    if (isset($_POST['rename_folder'])) {
        $old_name = $_POST['old_name'];
        $new_name = $_POST['new_name'];
        $old_path = "uploads/" . $old_name;
        $new_path = "uploads/" . $new_name;

        if (is_dir($old_path)) {
            rename($old_path, $new_path);
            echo "<p>Folder renamed successfully.</p>";
        } else {
            echo "<p>Folder not found.</p>";
        }
    }

    // Delete Folder
    if (isset($_GET['delete_folder'])) {
        $folder_name = $_GET['delete_folder'];
        $folder_path = "uploads/" . $folder_name;

        if (is_dir($folder_path)) {
            rmdir($folder_path); // Remove empty folder
            echo "<p>Folder deleted successfully.</p>";
        } else {
            echo "<p>Folder not found.</p>";
        }
    }

    // Get Files
    $sql = "SELECT * FROM files";
    $result = $conn->query($sql);

    // Get Folders (only directories)
    $folders = array_filter(scandir("uploads"), function($item) {
        return is_dir("uploads/" . $item) && $item != "." && $item != "..";
    });
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8; /* Lighter background */
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 2.8rem;
            color: #1e8e3e;
            margin-bottom: 50px;
        }

        /* Form Section */
        form {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin-bottom: 50px;
        }

        /* Input Fields */
        input[type="file"],
        input[type="text"] {
            padding: 20px;
            font-size: 1.2rem;
            border-radius: 12px;
            border: 1px solid #ccc;
            background-color: #f8f8f8;
            transition: all 0.3s ease;
        }

        input[type="file"]:focus,
        input[type="text"]:focus {
            border-color: #4CAF50;
            background-color: #ffffff;
        }

        input[type="file"]::placeholder,
        input[type="text"]::placeholder {
            color: #9e9e9e;
            font-style: italic;
        }

        /* Button Styles */
        button {
            padding: 18px;
            font-size: 1.3rem;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        /* Folder & File List */
        .folder-list,
        .file-list {
            margin-top: 50px;
        }

        .folder-item,
        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            margin-bottom: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .folder-item p,
        .file-item p {
            font-size: 1.4rem;
            color: #333;
        }

        .btn-delete,
        .btn-download {
            padding: 15px 25px;
            font-size: 1.1rem;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn-delete:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .btn-download {
            background-color: #3498db;
            color: #fff;
        }

        .btn-download:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        footer {
            text-align: center;
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-top: 50px;
        }

        /* Media Queries for Mobile Devices */
        @media (max-width: 768px) {
            .container {
                padding: 30px;
            }

            h2 {
                font-size: 2.2rem;
            }

            form {
                gap: 20px;
            }

            button {
                padding: 15px;
                font-size: 1.2rem;
            }
        }

    </style>
</head>
<body>

    <div class="container">
        <h2>File Management System</h2>

        <!-- Upload File Form -->
        <form action="files.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" placeholder="Choose file to upload" required>
            <button type="submit" name="upload">Upload File</button>
        </form>

        <!-- Create Folder Form -->
        <form action="files.php" method="POST">
            <input type="text" name="folder_name" placeholder="Enter new folder name" required>
            <button type="submit" name="create_folder">Create Folder</button>
        </form>

        <!-- Rename Folder Form -->
        <form action="files.php" method="POST">
            <input type="text" name="old_name" placeholder="Enter old folder name" required>
            <input type="text" name="new_name" placeholder="Enter new folder name" required>
            <button type="submit" name="rename_folder">Rename Folder</button>
        </form>

        <!-- Folder List -->
        <div class="folder-list">
            <h3>Folders</h3>
            <?php
                foreach ($folders as $folder) {
                    echo "<div class='folder-item'>";
                    echo "<p>$folder</p>";
                    echo "<a href='files.php?delete_folder=$folder' class='btn-delete'>Delete Folder</a>";
                    echo "</div>";
                }
            ?>
        </div>

        <!-- File List -->
        <div class="file-list">
            <h3>Files</h3>
            <?php
                while ($row = $result->fetch_assoc()) {
                    $file_id = $row['file_id'];
                    $filename = $row['filename'];
                    $file_path = $row['filepath'];

                    echo "<div class='file-item'>";
                    echo "<p>$filename</p>";
                    echo "<a href='$file_path' class='btn-download' download>Download</a>";
                    echo "<a href='files.php?delete_file=$file_id' class='btn-delete'>Delete File</a>";
                    echo "</div>";
                }
            ?>
        </div>

        <footer>
            <p>&copy; 2024 File Management System | Designed with ❤️ by Chunduri Bhavana</p>
        </footer>
    </div>

</body>
</html>
