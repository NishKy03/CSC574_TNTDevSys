<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once 'dbConnect.php'; // Adjust the path as per your project structure

// Retrieve staffID from session or set a default value
$staffID = isset($_SESSION['staffID']) ? $_SESSION['staffID'] : null;

if ($staffID) {
    // Check if a file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Process file upload
        $file = $_FILES['profile_picture'];

        // File properties
        $fileName = $file['name'];
        $fileTempName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // File extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        // Check if file type is allowed
        if (in_array($fileExt, $allowedExtensions)) {
            // Generate a unique file name
            $newFileName = 'profile_' . $staffID . '.' . $fileExt;

            // File destination path
            $uploadPath = 'uploads/profile/' . $newFileName;

            // Move uploaded file to destination
            if (move_uploaded_file($fileTempName, $uploadPath)) {
                // Update profile picture path in the database
                $updateQuery = "UPDATE Staff SET profilePicture = ? WHERE staffID = ?";
                $stmt = $dbCon->prepare($updateQuery);
                $stmt->bind_param('si', $uploadPath, $staffID);
                $stmt->execute();
                $stmt->close();

                // Redirect to profile page or display success message
                if($_SESSION['position'] == 'staff') {
                    header('Location: CDashboard.php');
                } else if($_SESSION['position'] == 'courier') {
                header('Location: deliverylist.php');
                exit();
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File type not supported. Please upload a JPG, JPEG, or PNG file.";
        }
    } else {
        echo "No file uploaded or an error occurred during upload.";
    }
} else {
    echo "Staff ID not found.";
}
?>
