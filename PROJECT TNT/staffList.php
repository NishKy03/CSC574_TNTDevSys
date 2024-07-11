<?php
session_start();
if (!isset($_SESSION['staffID'])) {
    echo '<div class="access-denied">Only Accessible by Staff</div>';
    echo "<script>window.location = 'login.php';</script>";
    exit();
}

require_once 'dbConnect.php';

$username = $_SESSION["staffName"];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$countQuery = "SELECT COUNT(*) AS total FROM staff";
$countResult = $dbCon->query($countQuery);
$countRow = $countResult->fetch_assoc();
$totalRecords = $countRow['total'];

$totalPages = ceil($totalRecords / $limit);

$sql = "SELECT * FROM staff LIMIT $limit OFFSET $offset";
$result = $dbCon->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Lists</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            line-height: normal;
            background-color: #ECE0D1;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            width: 80%;
            margin-top: 7%;
            margin-bottom: 2%;
            padding: 20px;
            background-color: #F5ECD0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .access-denied {
            color: red;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }

        .btn-register {
            background-color: #FFC107;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-register:hover {
            background-color: #FFD742;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table td {
            background-color: #fff;
        }

        table th {
            background-color: #4b0606;
            color: white;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination li {
            list-style: none;
            margin: 0 5px;
        }

        .pagination li a {
            color: #333;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .pagination li.active a {
            background-color: #007BFF;
            color: white;
            border: 1px solid #007BFF;
        }

        .pagination li a:hover:not(.active) {
            background-color: #ddd;
        }

        .btn-tertiary {
            background: none;
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .btn-tertiary:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <?php include("CHeader.php"); ?>

    <div class="container">
        <h2>Staff Lists</h2>
        <a href="RegisterStaff.php" class="btn-register">Register Staff</a><br><br>

        <?php if ($result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Branch ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row["staffID"]; ?></td>
                            <td><?php echo $row["staffName"]; ?></td>
                            <td><?php echo $row["staffPhone"]; ?></td>
                            <td><?php echo $row["staffEmail"]; ?></td>
                            <td><?php echo $row["position"]; ?></td>
                            <td><?php echo $row["branchID"]; ?></td>
                            <td>
                                <button class="btn btn-tertiary me-2" onclick="location.href='updateStaffInfo.php?id=<?php echo $row["staffID"]; ?>'"><img src="images/edit.png" alt="Edit" title="Edit"></button>
                                <button class="btn btn-tertiary me-2" onclick="confirmDelete(<?php echo $row["staffID"]; ?>)"><img src="images/delete.png" alt="Delete" title="Delete"></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>0 results</p>
        <?php endif; ?>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                <?php if ($page < $totalPages) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script>
        function confirmDelete(staffID) {
            if (confirm("Are you sure you want to delete this staff member?")) {
                window.location.href = 'deleteStaff.php?id=' + staffID;
            }
        }
    </script>
</body>
</html>
