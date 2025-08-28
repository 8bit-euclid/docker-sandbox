<?php
include './inc/functions.inc.php';

// Define the directory for images
$uploadDir = './images/';
$messages = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the directory is writable
    if (!is_writable($uploadDir)) {
        $messages[] = 'Error: The directory is not writable. Please check the permissions.';
    } else {
        // Check if the file was uploaded
        if (isset($_FILES['image'])) {
            $error = $_FILES['image']['error'];
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $fileTmpPath = $_FILES['image']['tmp_name'];
                    $fileName = $_FILES['image']['name'];
                    $fileSize = $_FILES['image']['size'];
                    $fileType = $_FILES['image']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));

                    // Sanitize file name
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                    // Allow only certain file types
                    $allowedFileExtensions = array('jpg', 'gif', 'png', 'jpeg');
                    if (in_array($fileExtension, $allowedFileExtensions)) {
                        // Check if file already exists
                        if (file_exists($uploadDir . $newFileName)) {
                            $messages[] = 'Error: File already exists. Please try again with a different file.';
                        } else {
                            // Move the file to the directory
                            $dest_path = $uploadDir . $newFileName;
                            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                $messages[] = 'File is successfully uploaded.';
                            } else {
                                $messages[] = 'Error: There was an error moving the uploaded file.';
                            }
                        }
                    } else {
                        $messages[] = 'Error: Upload failed. Allowed file types: ' . implode(',', $allowedFileExtensions);
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $messages[] = 'Error: The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $messages[] = 'Error: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $messages[] = 'Error: The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $messages[] = 'Error: No file was uploaded. Please select a file to upload.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $messages[] = 'Error: Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $messages[] = 'Error: Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $messages[] = 'Error: A PHP extension stopped the file upload.';
                    break;
                default:
                    $messages[] = 'Error: An unknown error occurred.';
                    break;
            }
        } else {
            $messages[] = 'Error: ' . $_FILES['image']['error'];
        }
    }
}
?>
<?php include './views/header.php'; ?>

    <?php
        // Display messages
        if (!empty($messages)) {
            echo '<div class="notice"><ul>';
            foreach ($messages as $message) {
                echo '<li>' . htmlspecialchars($message) . '</li>';
            }
            echo '</ul></div>';
        }
    ?>
<?php if (!empty($success)) : ?>
    <div class="notice">File successfully uploaded.</div>
<?php else: ?>
    <form method="POST" action="<?php echo e($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <label for="image-input">
            Select image:
            <input type="file" name="image" id="image-input" />
        </label>
        <input type="submit" value="Upload memory!" />
    </form>
<?php endif; ?>
<?php include './views/footer.php'; ?>
