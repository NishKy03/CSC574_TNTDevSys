<?php
    include('CHeader.php');
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
            background: linear-gradient(0deg, rgba(148, 148, 148, 0.61) 0%, rgba(148, 148, 148, 0.61) 20%), url('../images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: "Poppins", sans-serif;
            }
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }
            .chart-container {
                background: rgba(255, 255, 255, 0.8);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="chart-container">
                <h2>Orders Delivered by Staff</h2>
                <?php
                    require_once "dbConnect.php";

                    $sql = "SELECT t.staffID, COUNT(t.staffID) as total
                            FROM TRACKING_UPDATE t JOIN STAFF s
                            ON t.staffID = s.staffID
                            WHERE category = 'Delivered'
                            AND s.position = 'courier'
                            AND s.branchID = ?
                            GROUP BY t.staffID;";
                    
                    if ($stmt = mysqli_prepare($dbCon, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "d", $param_bID);
            
                        // Set parameters
                        $param_bID = $_SESSION['branchID'];
            
                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }

                    $labels = [];
                    $data = [];

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $labels[] = $row["staffID"];
                            $data[] = $row["total"];
                        }
                    }
                    mysqli_free_result($result);
                    mysqli_close($dbCon);
                ?>
                <canvas id="ordersChart" style="width:100%; max-width:800px; height:400px;"></canvas>
                <script>
                    const xValues = <?php echo json_encode($labels); ?>;
                    const yValues = <?php echo json_encode($data); ?>;
                    var chartType = "bar";

                    new Chart("ordersChart", {
                        type: chartType,
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: '#3B3B25',
                                data: yValues
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {display: false},
                                title: {
                                    display: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </body>
</html>