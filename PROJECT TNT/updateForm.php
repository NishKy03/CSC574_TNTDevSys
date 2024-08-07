<?php
include('CHeader.php');
require_once "dbConnect.php";

// Initialize variables
$orderID = $category = $branchID = $staffID = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate orderID (you may need additional validation here)
    $orderID = trim($_POST["orderID"]);
    $category = $_POST["category"];
    $branchID = $_POST["branchID"];
    $staffID = isset($_POST["staffID"]) ? $_POST["staffID"] : null;

    $nextUpdateID = 7000001;
    $sql1 = "SELECT MAX(updateID) AS maxUpdateID FROM tracking_update";
    $result = mysqli_query($dbCon, $sql1);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['maxUpdateID']) {
            $nextUpdateID = $row['maxUpdateID'] + 1;
        }
    }
    // Prepare the appropriate SQL update statement
    if ($category === "Delivery" && !empty($staffID)) {
        $sql2 = "INSERT INTO tracking_update (updateID, date, category, staffID, branchID, orderID) VALUES (?, CURDATE(), ?, ?, ?, ?)";
        $orderStatusUpdate = "UPDATE orders SET status = 'Out for Delivery' WHERE orderID = ?";
    } elseif ($category === "Departure") {
        $sql2 = "INSERT INTO tracking_update (updateID, date, category, branchID, orderID) VALUES (?, CURDATE(), ?, ?, ?)";
        $orderStatusUpdate = "UPDATE orders SET status = 'In Transit' WHERE orderID = ?";
    } else {
        $sql2 = "INSERT INTO tracking_update (updateID, date, category, branchID, orderID) VALUES (?, CURDATE(), ?, ?, ?)";
        $orderStatusUpdate = null; // No status update for other categories
    }

    if ($stmt = mysqli_prepare($dbCon, $sql2)) {
        // Bind variables to the prepared statement as parameters
        if ($category === "Delivery" && !empty($staffID)) {
            mysqli_stmt_bind_param($stmt, "issss", $nextUpdateID, $category, $staffID, $branchID, $orderID);
        } else {
            mysqli_stmt_bind_param($stmt, "isss", $nextUpdateID, $category, $branchID, $orderID);
        }

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Update the order status if required
            if ($orderStatusUpdate) {
                if ($statusStmt = mysqli_prepare($dbCon, $orderStatusUpdate)) {
                    mysqli_stmt_bind_param($statusStmt, "s", $orderID);
                    mysqli_stmt_execute($statusStmt);
                    mysqli_stmt_close($statusStmt);
                }
            }

            // Set session variable to indicate success
            $_SESSION['update_success'] = true;

            // Close statement
            mysqli_stmt_close($stmt);

            // Output a script block to handle the alert and redirection
            echo '<script>
                alert("Successfully updated order");
                window.location.href = "COrderList.php";
                </script>';
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
} else {
    // Fetch existing order details for display
    if (isset($_GET["orderID"]) && !empty(trim($_GET["orderID"]))) {
        $orderID = trim($_GET["orderID"]);

        // Prepare a select statement to get branch
        $sql1 = "SELECT branchID, CONCAT(branchID, ' - ', name) as branchName FROM branch ORDER BY branchID";
        $rsBranch = mysqli_query($dbCon, $sql1);
    } else {
        // Redirect to error page if orderID is not provided
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ece0d1;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin-top: 10%;
        }

        .form-container {
            position: relative;
            border: none;
            padding: 20px;
            border-radius: 10px;
            background-color: #4b0606;
            width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
        }
        .button-close .btn-close {
            position: absolute;
            background-color: transparent;
            border: none;
            font-size: 40px;
            cursor: pointer;
            right: 4px;
            top: 2px;
            color: white;
        }
        .form-container h2 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: white;
            margin-left: 40px;
        }
        .form-container input[type="text"], .form-container select {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .button-confirm button {
            width: 30%;
            padding: 10px;
            margin-top: 10px;
            background-color: #b45858;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
        }
        .button-confirm button:hover {
            background-color: #45a049;
        }
        .form-container a {
            text-decoration: none;
            color: #cccccc;
            font-size: 14px;
        }
        .form-container a:hover {
            text-decoration: underline;
        }
        .form-container input.non-editable {
            background-color: transparent;
            color: #fff;
            border: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="button-close">
                <button class="btn-close">&times;</button>
            </div>
            <h2>Update Order</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label>Order ID</label>
                <input type="text" name="orderID" value="<?php echo $orderID; ?>" class="non-editable" readonly>
                <label for="category">Category</label>
                <select id="category" name="category" onchange="showSecondDropdown()">
                    <option value="Arrival">Arrival</option>
                    <option value="Departure">Departure</option>
                    <option value="Delivery">Delivery</option>
                </select>
                <label for="branchID">Branch ID</label>
                <select id="branchID" name="branchID" onchange="fetchStaff()">
                    <?php 
                        while ($row = mysqli_fetch_assoc($rsBranch)) { ?>
                        <option value="<?php echo $row['branchID']; ?>">
                            <?php echo $row['branchName']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div id="staff" style="display: none;">
                    <label for="staffID">Staff ID</label>
                    <select id="staffID" name="staffID">
                        <!-- Options will be populated by AJAX -->
                    </select>
                </div>
                <div class="button-confirm">
                    <button type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var closeButton = document.querySelector(".btn-close");
            closeButton.addEventListener("click", function() {
                window.history.back();
            });

            // Function to toggle staff dropdown visibility
            function showSecondDropdown() {
                var category = document.getElementById("category").value;
                var staffDropdown = document.getElementById("staff");

                if (category === "Delivery") {
                    staffDropdown.style.display = "block";
                } else {
                    staffDropdown.style.display = "none";
                }
            }

            // Attach event listener to the category dropdown
            var categoryDropdown = document.getElementById("category");
            categoryDropdown.addEventListener("change", showSecondDropdown);

            // AJAX request to fetch staff based on branchID
            function fetchStaff() {
                var branchID = document.getElementById("branchID").value;
                var category = document.getElementById("category").value;

                if (category === "Delivery") {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "fetchOrderDetails.php?branchID=" + branchID, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var staffDropdown = document.getElementById("staffID");
                            staffDropdown.innerHTML = xhr.responseText;
                        }
                    };
                    xhr.send();
                }
            }

            // Attach event listener to the branch dropdown
            var branchDropdown = document.getElementById("branchID");
            branchDropdown.addEventListener("change", fetchStaff);
        });
    </script>
</body>
</html>
