<?php
session_start();

$base_dir = "/var/www/html";
$current_dir = isset($_GET['dir']) ? $_GET['dir'] : $base_dir;

function displayFolderContents($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $file_path = $dir . '/' . $file;
            if (is_dir($file_path)) {
                echo "<div class=\"container bg-light p-2 mb-2\">
                          <a href=\"index.php?dir=$file_path\">$file (Folder)</a> - 
                          <a href=\"index.php?dir=$dir&delete=$file\" onclick=\"return confirm('Apakah Anda yakin ingin menghapus folder ini?')\">Delete</a>
                      </div>";
            } else {
                $file_url = str_replace('/var/www/html', '', $file_path);
                $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif'))) {
                    echo "<div class=\"container bg-light p-2 mb-2\">
                              <a href=\"$file_url\" target=\"_blank\"><img src=\"$file_url\" alt=\"$file\" style=\"max-width: 300px;\"></a> - 
                              <a href=\"index.php?dir=$dir&delete=$file\" onclick=\"return confirm('Apakah Anda yakin ingin menghapus file ini?')\">Delete</a>
                          </div>";
                } else {
                    echo "<div class=\"container bg-light p-2 mb-2\">
                              <a href=\"$file_url\" target=\"_blank\">$file</a> - 
                              <a href=\"index.php?dir=$dir&delete=$file\" onclick=\"return confirm('Apakah Anda yakin ingin menghapus file ini?')\">Delete</a>
                          </div>";
                }
            }
        }
    }
}

function createNewFolder($dir, $new_folder_name) {
    $new_folder_path = $dir . '/' . $new_folder_name;
    if (!file_exists($new_folder_path)) {
        if (mkdir($new_folder_path, 0777, true)) {
            $_SESSION['alert'] = "Folder created successfully.";
        } else {
            $_SESSION['alert'] = "Failed to create folder.";
        }
    } else {
        $_SESSION['alert'] = "Folder already exists.";
    }
    header("Location: index.php?dir=$dir");
    exit();
}
function deleteFolderOrFile($dir, $name) {
    $path = $dir . '/' . $name;
    if (is_dir($path)) {
        removeDirectory($path);
        $_SESSION['alert'] = "Folder deleted successfully.";
    } else {
        if (unlink($path)) {
            $_SESSION['alert'] = "File deleted successfully.";
        } else {
            $_SESSION['alert'] = "Failed to delete folder or file.";
        }
    }
    header("Location: index.php?dir=$dir");
    exit();
}

function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
}

function runPythonFile($file_path) {
    $output = shell_exec("python3 " . $file_path);
    echo "<pre>$output</pre>";
}

function uploadFile($dir) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target_dir = $dir . '/';
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $_SESSION['alert'] = "File uploaded successfully.";
        } else {
            $_SESSION['alert'] = "Failed to upload file.";
        }
        header("Location: index.php?dir=$dir");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $delete_name = $_GET['delete'];
    deleteFolderOrFile($current_dir, $delete_name);
}

if (isset($_POST['create_folder'])) {
    createNewFolder($current_dir, $_POST['new_folder_name']);
}

if (isset($_GET['delete'])) {
    $delete_name = $_GET['delete'];
    deleteFolderOrFile($current_dir, $delete_name);
}

uploadFile($current_dir);

?>

<!DOCTYPE html>
<html>
<head>
    <title>File Explorer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">File Explorer</a>
    </nav>

    <div class="container mt-3">
        <?php
        if (isset($_SESSION['alert'])) {
            echo "<div class=\"alert alert-primary\" role=\"alert\">";
            echo $_SESSION['alert'];
            echo "</div>";
            unset($_SESSION['alert']);
        }
        ?>

        <h2>Current Folder: <?php echo $current_dir; ?></h2>

        <h2>Folder Contents</h2>
        <?php displayFolderContents($current_dir); ?>

        <h2>Create Folder</h2>
       <form action="index.php?dir=<?php echo $current_dir; ?>" method="post">
    <input type="text" name="new_folder_name" placeholder="New Folder Name">
    <input type="submit" value="Create Folder" name="create_folder">
</form>

        <h2>Upload File</h2>
        <form action="index.php?dir=<?php echo $current_dir; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File" name="upload">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
