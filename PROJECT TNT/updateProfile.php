<?php
session_start();
include 'dbConnect.php';

// Check if staffID is set in session
if (!isset($_SESSION['staffID'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated data from the form
    $staffID = $_SESSION['staffID'];
    $staffName = $_POST['staffName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $question = $_POST['question']; // Ensure this matches the name attribute in the <select>
    $answer = $_POST['answer'];

    // Update query
    $sql = "UPDATE Staff SET staffName = ?, staffPhone = ?, staffEmail = ?, staffQuestion = ?, staffAnswer = ? WHERE staffID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("sssssi", $staffName, $phone, $email, $question, $answer, $staffID);

    // Execute the update query
    if ($stmt->execute()) {
        // Update successful, redirect back to profile page with success parameter
        header("Location: myProfileStaff.php?update=success");
        exit();
    } else {
        // Handle update failure
        echo "Update failed. Please try again.";
    }

    $stmt->close();
    $dbCon->close();
} else {
    // Redirect to profile page if accessed directly without POST data
    header("Location: myProfileStaff.php");
    exit();
}
?>
