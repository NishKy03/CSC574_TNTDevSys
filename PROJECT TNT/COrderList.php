<?php
    include('CHeader.php');
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
                padding: 20px;
            }

            .content {
                width: 100%;
                max-width: 1200px;
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
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>ORDERS (Branch ID: <?php echo $_SESSION['branchID']?>)</h1>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Branch ID</th>
                            <th>Order Date</th>
                            <th>State (Recipient)</th>
                            <th>Status</th>
                            <th>Delivery Staff ID & Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Include dbConnect file
                        require_once "dbConnect.php";
                        // Attempt select query execution
                        $sql = "SELECT o.orderID, t.branchID, o.orderDate, r.state, t.category, t.staffID, s.staffName
                                FROM recipient r
                                JOIN orders o ON r.recipientID = o.recipientID
                                LEFT JOIN tracking_update t ON o.orderID = t.orderID
                                LEFT JOIN staff s ON t.staffID = s.staffID
                                WHERE t.updateID IN (SELECT MAX(updateID) FROM tracking_update GROUP BY orderID)
                                AND t.branchID = ?;";
                        if ($stmt = mysqli_prepare($dbCon, $sql)) {
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "s", $param_bID);
                            
                            // Set parameters
                            $param_bID = $_SESSION['branchID'];
                            
                            // Attempt to execute the prepared statement
                            if (mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        $orderID = $row['orderID'];
                                        echo "<td>" . $orderID . "</td>";
                                        echo "<td>". $row["branchID"] ."</td>";
                                        echo "<td>" . $row['orderDate'] . "</td>";
                                        echo "<td>" . $row['state'] . "</td>";
                                        echo "<td>" . $row['category'] . "</td>\n";
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
                                    };

                                    // Free result set
                                    mysqli_free_result($result);
                                } else {
                                    echo "<tr><td colspan='7'><em>No records were found.</em></td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>ERROR: Could not execute $sql. " . mysqli_error($dbCon) . "</td></tr>";
                            }

                            // Close statement
                            mysqli_stmt_close($stmt);
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
