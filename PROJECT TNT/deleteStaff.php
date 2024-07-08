<?php
session_start();

require_once 'dbConnect.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["position"] !== 'staff') {
    echo "<script>alert(You are not authorized to view this page. Please log in as staff.)</script>";
    header("location: login.php");
    exit;
}

$staffID = $_GET['id'];

$sql = "DELETE FROM Staff WHERE staffID = '$staffID'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert(Record deleted successfully)</script>";
} else {
    echo "<script>Error: " . $sql . "<br>" . $conn->error . "</script>";
}

$conn->close();
header("Location: staffList.php");
?>
