<?php
require_once "dbConnect.php";

// Fetch staff based on branchID
if (isset($_GET["branchID"]) && !empty(trim($_GET["branchID"]))) {
    $branchID = trim($_GET["branchID"]);

    $sql = "SELECT staffID, staffName FROM staff WHERE branchID = ?";
    if ($stmt = mysqli_prepare($dbCon, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $branchID);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo '<option value="' . $row["staffID"] . '">' . $row["staffID"] . ' - ' . $row["staffName"] . '</option>';
                }
            } else {
                echo '<option value="">No staff found</option>';
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo '<option value="">Invalid branch ID</option>';
}

mysqli_close($dbCon);
?>
