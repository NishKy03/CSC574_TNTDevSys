<?php
session_start();
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_SESSION['staffID'];
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['conpassword'];

    if ($newPassword === $confirmPassword) {
        // Update the password
        $sql = "UPDATE STAFF SET password = ? WHERE staffID = ?";
        $stmt = $dbCon->prepare($sql);
        $stmt->bind_param("ss", $newPassword, $staffID);
        
        if ($stmt->execute()) {
            // Password updated successfully
            session_destroy(); // End session
            echo "<script>alert('Password has been successfully changed');window.location.href='login.php';</script>";
            exit();
        } else {
            $_SESSION['errorMessage'] = "Error updating password.";
            header("Location: changePassword.php");
            exit();
        }
    } else {
        echo "<script>alert('Password is not match');window.location.href='changePassword.php';</script>";
        exit();
    }
}
?>
