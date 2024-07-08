<?php 
include 'dbConnect.php';
include 'CHeader.php';

// Pagination variables
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5; // Number of records to display per page
$offset = ($page - 1) * $records_per_page; // Offset for SQL query

// SQL to fetch limited messages from the contactus table
$sql = "SELECT messageid, name, email, description FROM contactus LIMIT $offset, $records_per_page";
$result = $dbCon->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        html {
            background-image: url('images/bg.jpg'); /* Add the path to your background image */
            background-size: cover; /* Ensures the background image covers the entire body */
            background-position: 0px 50px; /* Centers the background image horizontally and vertically */
            background-repeat: no-repeat;
            height: 100%;
        }
        body {
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background-color: rgba(248, 249, 250, 0.35);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        h1 {
            color: #000;
            text-align: center;
            font-weight: 800;
            margin-top: 6%;
        }
        .container {
            margin-top: 20px; /* Adjust this margin as needed */
        }
        .table-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 1%;
            overflow-x: auto; /* Add horizontal scrolling if needed */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 10px; /* Adjust this margin as needed */
            margin-bottom: 20px; /* Added margin-bottom to create gap */
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            transition: background-color 0.3s, color 0.3s;
        }
        th {
            background-color: #4b0606;
            color: white;
        }
        td {
            color: #333;
        }
        tr:hover td {
            background-color: #f1f1f1;
            color: #4b0606;
        }
        .description-col {
            max-width: 500px; /* Set a maximum width for the description column */
            word-wrap: break-word; /* Break long words */
            white-space: pre-wrap; /* Preserve whitespace formatting */
        }
        .action-col {
            text-align: center;
        }
        .delete-button {
            color: #ff0000;
            cursor: pointer;
            text-decoration: none;
        }
        .delete-icon {
            color: #ff0000;
            cursor: pointer;
        }
        .delete-icon:hover {
            color: #cc0000;
        }
        .pagination-container {
            text-align: center;
            margin-top: 5px;
            margin-bottom:20px;
        }
        .pagination-container a {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <h1>Messages</h1>
    <div class="table-container">
    <?php
        if ($result->num_rows > 0) {
            // Output data as HTML table
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th class='description-col'>Description</th>
                            <th class='action-col'>Action</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['messageid']."</td>
                        <td>".$row['name']."</td>
                        <td>".$row['email']."</td>
                        <td class='description-col'>".$row['description']."</td>
                        <td class='action-col'>
                            <a href='deleteMessage.php?id=".$row['messageid']."' class='delete-icon'><i class='fas fa-trash-alt'></i></a>
                        </td>
                    </tr>";
            }

            echo "</tbody></table>"; ?>
            </div>
            <?php
            // Pagination links
            $sql_pagination = "SELECT COUNT(*) AS total FROM contactus";
            $result_pagination = $dbCon->query($sql_pagination);
            $row_pagination = $result_pagination->fetch_assoc();
            $total_pages = ceil($row_pagination['total'] / $records_per_page);

            echo "<div class='pagination-container'>";
            if ($page > 1) {
                echo "<a href='message.php?page=".($page - 1)."' class='btn btn-primary'>Previous</a>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='message.php?page=".$i."' class='btn btn-primary'>".$i."</a>";
            }
            if ($page < $total_pages) {
                echo "<a href='message.php?page=".($page + 1)."' class='btn btn-primary'>Next</a>";
            }
            echo "</div>";
        } else {
            echo 'No messages found.';
        }

        $dbCon->close();
    ?>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
