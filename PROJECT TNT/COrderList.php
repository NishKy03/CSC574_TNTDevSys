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

            .content {
            flex: 1;
            padding: 20px;
            padding-top: 100px;
            box-sizing: border-box;
            }
            .content h1 {
                color: #7a2321;
                font: weight 700px;;
                margin-bottom: 20px;
            }
            .order-table {
                width: 100%;
                border-collapse: collapse;
            }
            .order-table th, .order-table td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: left;
            }
            .order-table th {
                background: #b9876d;
                color: white;
            }
            .order-table tr:nth-child(even) {
                background: #f2f2f2;
            }
            .order-table tr:hover {
                background: #ddd;
            }
            .update-button {
                background: #56c4e1;
                border: none;
                padding: 5px 10px;
                color: white;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>ORDERS (Branch ID: <?php echo $_SESSION['branchID']?>)</h1>
                <table class="order-table">
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>State (Recipient)</th>
                        <th>Status</th>
                        <th>Delivery Staff ID</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        // Include dbConnect file
                        require_once "dbConnect.php";
                        // Attempt select query execution
                        $sql = "SELECT o.orderID, o.orderDate, r.state, t.category, t.staffID
                                FROM recipient r, orders o, tracking_update t, staff s
                                WHERE o.orderID = t.orderID
                                AND t.staffID = s.staffID
                                AND r.recipientID = o.recipientID
                                AND updateID IN (SELECT MAX(updateID)
                                                FROM tracking_update
                                                GROUP BY orderID)
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
                                        echo "<td>" . $row['orderDate'] . "</td>";
                                        echo "<td>" . $row['state'] . "</td>";
                                        echo "<td>" . $row['category'] . "</td>\n";
                                        echo "<td>" . $row['staffID'] . "</td>\n";
                                        echo "<td>";
                                        echo "<a href='printOrderStatement.php?orderID=" . $orderID . "' target=\"popup\" onclick=\"window.open('printOrderStatement.php?orderID=" . $orderID . "', '_blank', 'width=600,height=400'); return false;\">Print Statement</a>&nbsp;&nbsp;";
                                        echo "<a href='printOrderWaybill.php?orderID=" . $orderID . "' target=\"popup\" onclick=\"window.open('printOrderWaybill.php?orderID=" . $orderID . "', '_blank', 'width=600,height=400'); return false;\">Print Waybill</a>&nbsp;&nbsp;";
                                        echo "<a href='updateForm.php?orderID=" . $orderID . "' title='Update'>Update</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    };

                                    // Free result set
                                    mysqli_free_result($result);
                                } else {
                                    echo "<p><em>No records were found.</em></p>";
                                }
                            } else {
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($dbCon);
                            }

                            // Close connection
                            mysqli_close($dbCon);
                        }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>