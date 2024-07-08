<?php
session_start();
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_POST['userid'];
    
    $sql = "SELECT staffQuestion FROM STAFF WHERE staffID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("s", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        // User ID exists, fetch the security question
        $row = $result->fetch_assoc();
        $_SESSION['staffID'] = $staffID;
        $_SESSION['staffQuestion'] = $row['staffQuestion'];
        header("Location: answerSecurityQuestion.php");
        exit();
    } else {
        $_SESSION['errorMessage'] = "User ID not found.";
        header("Location: forgotPassword.php");
        exit();
    }
}
?>
