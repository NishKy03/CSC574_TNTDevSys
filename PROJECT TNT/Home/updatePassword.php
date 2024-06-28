<?php
session_start(); // Start session to store message temporarily

include '../dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];
    $newpassword = $_POST['newpassword'];
    $conpassword = $_POST['conpassword'];

    if ($newpassword === $conpassword) {
        $sql = "UPDATE staff SET password = ? WHERE staffID = ?";
        if ($stmt = $dbCon->prepare($sql)) {
            $stmt->bind_param("ss", $newpassword, $userid);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Password updated successfully.";
                $stmt->close();
                echo "<script>alert('Password updated successfully.'); window.location='login.php';</script>";
                exit(); // Ensure script execution stops after redirection
            } else {
                $_SESSION['error'] = "Error updating password: " . $stmt->error;
                $stmt->close();
                echo "<script>alert('Error updating password: " . $stmt->error . "'); window.location='forgotPassword.php';</script>";
                exit(); // Ensure script execution stops after redirection
            }
        } else {
            $_SESSION['error'] = "Error preparing statement: " . $dbCon->error;
            echo "<script>alert('Error preparing statement: " . $dbCon->error . "'); window.location='forgotPassword.php';</script>";
            exit(); // Ensure script execution stops after redirection
        }
    } else {
        $_SESSION['error'] = "Passwords do not match.";
        echo "<script>alert('Passwords do not match.'); window.location='forgotPassword.php';</script>";
        exit(); // Ensure script execution stops after redirection
    }
}

$dbCon->close();
?>
