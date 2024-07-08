<?php
session_start();

require_once 'dbConnect.php';

if (!isset($_SESSION["staffID"]) || $_SESSION["position"] !== 'staff') {
    echo "<script>alert(You are not authorized to view this page. Please log in as staff.)</script>";
    header("location: login.php");
    exit();
}

$staffID = $_GET['id'];

$sql = "DELETE FROM Staff WHERE staffID = '$staffID'";

if ($dbCon->query($sql) === TRUE) {
    echo "<script>alert(Record deleted successfully)</script>";
} else {
    echo "<script>Error: " . $sql . "<br>" . $dbCon->error . "</script>";
}

$dbCon->close();
header("Location: staffList.php");
?>
