<?php
session_start();
if (!isset($_SESSION['staffID'])) {
    echo '<div class="access-denied">Only Accessible by Staff</div>';
    exit();
}

require_once '../dbConnect.php'; // Adjust the path as per your project structure

// Check if staff position is 'courier'
if ($_SESSION['position'] !== 'courier') {
    echo '<div class="access-denied">Access Denied. Only accessible by courier staff.</div>';
    exit();
}

// Handle status filter selection
$filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$filterQuery = '';

switch ($filter) {
    case 'out_for_delivery':
        $filterQuery = " AND ORDERS.status = 'Out for Delivery'";
        break;
    case 'shipped':
        $filterQuery = " AND ORDERS.status = 'Shipped'";
        break;
    case 'in_progress':
        $filterQuery = " AND ORDERS.status = 'In Progress'";
        break;
    case 'Deliverd':
        $filterQuery = " AND ORDERS.status = 'Delivered'";
    default:
        // 'all' filter includes all statuses, no additional filter query needed
        break;
}

$staffID = $_SESSION['staffID'];
$staffName = $_SESSION['staffName'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../header.css">
    <script src="../sidebar.js" defer></script>
    <title>Tracking - TNT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            width: 100%;
            justify-content: center; /* Center content horizontally */
        }

        .main-content {
            width: 63%;
        }


        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto; /* Center the table horizontally */
            outline: 1px solid black;
            border-radius: 10px;
            overflow:hidden;
        }

        td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
        }

        h1 {
            background-color: rgba(75, 6, 6, 0.2); /* Background color with 70% opacity */
            color: #38040E;
            margin-left: -30%; 
            padding: 10px;
            padding-left: 20px; /* Adjust the left padding as needed */
            margin-top: 0;
            width: calc(200%); /* Adjust width to cover entire screen */
        }

        .access-denied {
            background-color: #4B0606;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 100px auto;
            width: 50%;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Style for the "Done" button */
        input[type="submit"][name="done"] {
            background-color: #4B0606;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        input[type="submit"][name="done"]:hover {
            background-color: #38040E;
        }

        input[type="submit"][name="done"]:focus {
            outline: none;
        }

        /* Style for the filter dropdown */
        .filter select {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
            margin-right: 20px;
            margin-bottom: 10px;
        }

        .filter label {
            font-size: 16px;
            font-weight: bold;
            margin-right: 10px;
        }
        </style>
</head>
<body>
    <?php include 'headerStaffDelivery.php'; ?>
    <div class="container">
        <div class="main-content">
            <div class="headerstaff">
                <h1>STAFF ID: <?php echo htmlspecialchars($staffID); ?></h1>
            </div>
            <!-- Filter Section -->
            <div class="filter">
                <form method="get">
                    <label for="status">Filter by Status:</label>
                    <select name="status" id="status" onchange="this.form.submit()">
                        <option value="all" <?php if ($filter === 'all') echo 'selected'; ?>>All</option>
                        <option value="out_for_delivery" <?php if ($filter === 'out_for_delivery') echo 'selected'; ?>>Out for Delivery</option>
                        <option value="shipped" <?php if ($filter === 'shipped') echo 'selected'; ?>>Shipped</option>
                        <option value="in_progress" <?php if ($filter === 'in_progress') echo 'selected'; ?>>In Progress</option>
                        <option value="delivered" <?php if ($filter === 'delivered') echo 'selected'; ?>>Delivered</option>
                    </select>
                </form>
            </div>

            <!-- Delivery List Table -->
            <table>
                <thead>
                    <tr>
                        <th>Tracking ID</th>
                        <th>Recipient</th>
                        <th>Address</th>
                        <th>Proof of Delivery</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch delivery list from database with filter
                    $sql = "SELECT ORDERS.orderID, RECIPIENT.name, RECIPIENT.addressLine1, RECIPIENT.city, RECIPIENT.state, RECIPIENT.postcode, ORDERS.status FROM ORDERS JOIN RECIPIENT ON ORDERS.recipientID = RECIPIENT.recipientID WHERE 1" . $filterQuery;
                    $result = $dbCon->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["orderID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["addressLine1"] . ", " . $row["city"] . ", " . $row["state"] . " " . $row["postcode"]) . "</td>";
                            echo "<td>Image(x)</td>"; // Placeholder for proof of delivery image
                            echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                            echo "<td>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='orderID' value='" . $row['orderID'] . "'>";
                            echo "<input type='submit' name='done' value='Done'>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No deliveries found</td></tr>";
                    }

                    $dbCon->close(); // Close the database connection
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
