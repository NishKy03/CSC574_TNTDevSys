<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["userlevel"] !== '1') {
    header("location: login.php");
    exit;
}

$usrname = $_SESSION["username"];

$matricNo = $_GET['id'];

$sql = "DELETE FROM student WHERE Std_MatricNo='$matricNo'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("Location: students.php");
?>
