<?php
session_start();
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_POST['userid'];

    // Check if the staff ID exists in the database
    $sql = "SELECT staffID FROM Staff WHERE staffID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("i", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Set the session variable
        $_SESSION['staffID'] = $staffID;
        header("Location: answerSecurityQuestion.php");
        exit();
    } else {
        $_SESSION['errorMessage'] = "User ID not found.";
        header("Location: forgotPassword.php");
        exit();
    }

    $stmt->close();
    $dbCon->close();
} else {
    header("Location: forgotPassword.php");
    exit();
}
?>
