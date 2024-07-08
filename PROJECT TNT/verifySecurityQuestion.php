<?php
session_start();
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_SESSION['staffID'];
    $securityAnswer = $_POST['securityAnswer'];

    $sql = "SELECT staffAnswer FROM Staff WHERE staffID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("i", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['staffAnswer'] === $securityAnswer) {
            header("Location: changePassword.php");
            exit();
        } else {
            $_SESSION['wrongAnswer'] = true;
            header("Location: answerSecurityQuestion.php");
            exit();
        }
    } else {
        $_SESSION['errorMessage'] = "Security answer not found for the given user ID.";
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
