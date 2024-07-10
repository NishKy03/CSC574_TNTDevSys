<?php
    include('CHeader.php');
?>
<?php
    if (!isset($_SESSION['staffID'])) {
        echo '<div class="access-denied">Access Denied. Only accessible by regular staff.</div>';
        // JavaScript to redirect to login page after 2 seconds
        echo '<script type="text/javascript">
                setTimeout(function() {
                    window.location.href = "login.php"; // Change "login.php" to the URL of your login page
                }, 2000);
            </script>';
        exit();
    }

    require_once 'dbConnect.php'; // Adjust the path as per your project structure

    // Check if staff position is 'staff'
    if ($_SESSION['position'] !== 'staff') {
        echo '<div class="access-denied">Access Denied. Only accessible by regular staff.</div>';
        exit();
    }

    $sql1 = "SELECT branchID, CONCAT(branchID, ' - ', name) as branchName FROM branch ORDER BY branchID";
    $rsBranch = mysqli_query($dbCon, $sql1);

    // Handle status filter selection
    $filter = isset($_GET['branchID']) ? $_GET['branchID'] : 'all';
    $filterQuery = '';

    if ($filter !== 'all') {
        $filterQuery = " AND t.branchID = '".$filter."'";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Orders List</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                background: linear-gradient(0deg, rgba(148, 148, 148, 0.61) 0%, rgba(148, 148, 148, 0.61) 20%), url('images/bg.jpg') no-repeat center center fixed;
                background-size: cover;
                font-family: "Poppins", sans-serif;
            }

            .container {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 10px;
                margin-left: 8%;
            }

            .content {
                width: 100%;
                max-width: 1300px;
                margin-top: 100px;
                box-sizing: border-box;
            }

            .content h1 {
                color: #7a2321;
                font-weight: 700;
                margin-bottom: 20px;
                text-align: center;
            }

            .order-table {
                width: 100%;
                border-collapse: collapse;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                overflow: hidden;
            }

            .order-table th, .order-table td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: left;
                transition: background-color 0.3s, color 0.3s;
            }

            .order-table th {
                background: #b9876d;
                color: white;
                text-align: center;
            }

            .order-table tr {
                background: #f2f2f2;
            }

            .order-table tr:hover {
                background: #ddd;
            }

            .action-buttons {
                display: flex;
                gap: 5px;
            }

            .action-buttons a, .action-buttons button {
                background: #56c4e1;
                border: none;
                padding: 5px 10px;
                color: white;
                text-decoration: none;
                cursor: pointer;
                border-radius: 5px;
                font-size: 14px;
            }

            .action-buttons button:hover, .action-buttons a:hover {
                background: #45a3b8;
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
        <div class="container">
            <div class="content">
                <h1>ORDERS (Branch ID: <?php echo $_SESSION['branchID']?>)</h1>
                <div class="filter">
                    <form method="get">
                        <label for="branchID">Filter by Branch:</label>
                        <select name="branchID" id="branchID" onchange="this.form.submit()" class="form-control">
                            <option value="all" <?php if ($filter === 'all') echo 'selected'; ?>>All</option>
                            <?php 
                                while ($row = mysqli_fetch_assoc($rsBranch)) {
                                    $branchID = $row['branchID'];
                                    ?>
                                    <option value="<?php echo $branchID ?>" <?php if ($filter === $branchID) echo 'selected'; ?> >
                                        <?php echo $row['branchName']; ?>
                                    </option>
                            <?php } ?>
                        </select>
                    </form>
                </div>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Sender Name</th>
                            <th>Sender State</th>
                            <th>Recipient Name</th>
                            <th>Recipient State</th>
                            <th>Update Date</th>
                            <th>Status</th>
                            <th>Branch ID</th>
                            <th>Delivery Staff ID & Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Attempt select query execution
                        $sql = "SELECT o.orderID, DATE_FORMAT(o.orderDate, \"%d-%m-%Y\") AS orderDate, s.senderName, s.state AS senderState, r.name, r.state, DATE_FORMAT(t.date, \"%d-%m-%Y\") AS date, t.category, t.branchID, t.staffID, f.staffName
                                FROM recipient r, orders o, sender s, tracking_update t, staff f
                                WHERE r.recipientID = o.recipientID
                                AND s.senderID = o.senderID
                                AND o.orderID = t.orderID
                                AND t.staffID = f.staffID
                                AND t.updateID IN (SELECT MAX(updateID) FROM tracking_update GROUP BY orderID) ". $filterQuery;

                        $rsOrders = mysqli_query($dbCon, $sql);

                        while ($row = mysqli_fetch_assoc($rsOrders)) {
                            echo "<tr>";
                            $orderID = $row['orderID'];
                            echo "<td>" . $orderID . "</td>";
                            echo "<td style = \"white-space: nowrap;\">" . $row['orderDate'] . "</td>";
                            echo "<td>". $row["senderName"] ."</td>";
                            echo "<td>" . $row['senderState'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['state'] . "</td>";
                            echo "<td style = \"white-space: nowrap;\">" . $row['date'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>" . $row['branchID'] . "</td>";
                            if ($row['staffID']) {
                                echo "<td>" . $row['staffID'] . " - " . $row['staffName'] . "</td>\n";
                            } else {
                                echo "<td>Unassigned</td>\n";
                            }
                            echo "<td class='action-buttons'>";
                            echo "<a href='printOrderStatement.php?orderID=" . $orderID . "' target='_blank' onclick='window.open(this.href, \"popup\", \"width=600,height=400\"); return false;'>Print Statement</a>";
                            echo "<a href='printOrderWaybill.php?orderID=" . $orderID . "' target='_blank' onclick='window.open(this.href, \"popup\", \"width=600,height=400\"); return false;'>Print Waybill</a>";
                            echo "<a href='updateForm.php?orderID=" . $orderID . "' title='Update'>Update</a>";
                            echo "</td>";
                            echo "</tr>";
                        }

                        // Close connection
                        mysqli_close($dbCon);
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function assignOrder(orderID) {
                window.location.href = 'assignOrder.php?orderID=' + orderID;
            }
        </script>
    </body>
</html>