<?php
    include('CHeader.php');
    require_once "dbConnect.php"; // Include your database connection
    $branchID = $_SESSION['branchID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(0deg, rgba(148, 148, 148, 0.61) 0%, rgba(148, 148, 148, 0.61) 20%), url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: "Poppins", sans-serif;
            overflow:hidden;
        }
        .container {
            margin-top: 2%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            gap: 20px;
            padding: 20px;
        }
        .row {
            
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
            width: 100%;
            max-width: 1200px;
        }
        .chart-container, .revenue-container, .info-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            text-align: center;
        }
        .chart-container {
            flex: 2;
        }
        .info-container h2 {
            margin-bottom: 20px;
            color: #7a2321;
        }
        .info-container .info {
            font-size: 24px;
            color: #3B3B25;
        }
        .revenue-container h2 {
            margin-bottom: 20px;
            color: #7a2321;
        }
        .revenue-container .total-revenue {
            font-size: 24px;
            color: #3B3B25;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="info-container">
            <h2>Total Staff in Branch</h2>
            <?php
            // Query for total staff in branch
            $sql3 = "SELECT COUNT(*) as totalStaff FROM staff WHERE branchID = ?";
            if ($stmt3 = mysqli_prepare($dbCon, $sql3)) {
                mysqli_stmt_bind_param($stmt3, "s", $branchID);
                if (mysqli_stmt_execute($stmt3)) {
                    $result3 = mysqli_stmt_get_result($stmt3);
                    $row3 = mysqli_fetch_assoc($result3);
                    echo "<div class='info'>" . $row3['totalStaff'] . "</div>";
                } else {
                    echo "Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt3);
            } else {
                echo "ERROR: Could not execute query. " . mysqli_error($dbCon);
            }
            ?>
        </div>
        <div class="info-container">
            <h2>Total Message Received</h2>
            <?php
            // Query for total orders delivered
            $sql4 = "SELECT COUNT(*) as totalMessage FROM contactus";
            if ($stmt4 = mysqli_prepare($dbCon, $sql4)) {
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt4)) {
                    $result4 = mysqli_stmt_get_result($stmt4);
                    $row4 = mysqli_fetch_assoc($result4);
                    echo "<div class='info'>" . $row4['totalMessage'] . "</div>";
                } else {
                    echo "Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt4);
            } else {
                echo "ERROR: Could not execute query. " . mysqli_error($dbCon);
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="chart-container">
            <h2>Total Orders Delivered by <?php echo $branchID; ?> Staffs</h2>
            <?php
            // Query for orders delivered by staff
            $sql1 = "SELECT t.staffID, COUNT(t.staffID) as total
                     FROM tracking_update t
                     JOIN staff s ON t.staffID = s.staffID
                     WHERE t.category = 'Delivered' 
                     AND s.branchID = ?
                     GROUP BY t.staffID";
            if ($stmt1 = mysqli_prepare($dbCon, $sql1)) {
                mysqli_stmt_bind_param($stmt1, "s", $branchID);
                if (mysqli_stmt_execute($stmt1)) {
                    $result1 = mysqli_stmt_get_result($stmt1);
                    $labels = [];
                    $data = [];
                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        $labels[] = $row1['staffID'];
                        $data[] = $row1['total'];
                    }
                } else {
                    echo "Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt1);
            } else {
                echo "ERROR: Could not execute query. " . mysqli_error($dbCon);
            }
            ?>
            <canvas id="ordersChart" style="width:100%; max-width:800px; height:400px;"></canvas>
            <script>
                const xValues = <?php echo json_encode($labels); ?>;
                const yValues = <?php echo json_encode($data); ?>;
                new Chart("ordersChart", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: '#3B3B25',
                            data: yValues
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            title: { display: true }
                        }
                    }
                });
            </script>
        </div>
        <div class="revenue-container">
            <h2>Total Revenue Collected by <?php echo $branchID; ?></h2>
            <?php
            // Query for total revenue
            $sql2 = "SELECT SUM(o.totalAmount) as totalRevenue 
                     FROM orders o 
                     JOIN tracking_update t ON o.orderID = t.orderID
                     WHERE t.branchID = ?";
            if ($stmt2 = mysqli_prepare($dbCon, $sql2)) {
                mysqli_stmt_bind_param($stmt2, "s", $branchID);
                if (mysqli_stmt_execute($stmt2)) {
                    $result2 = mysqli_stmt_get_result($stmt2);
                    $row2 = mysqli_fetch_assoc($result2);
                    echo "<div class='total-revenue'>RM" . number_format($row2['totalRevenue'], 2) . "</div>";
                } else {
                    echo "Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt2);
            } else {
                echo "ERROR: Could not execute query. " . mysqli_error($dbCon);
            }
            // Close the database connection
            mysqli_close($dbCon);
            ?>
        </div>
    </div>
</div>
</body>
</html>
