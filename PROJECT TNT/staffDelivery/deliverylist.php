<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../header.css">
    <title>Tracking - TNT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4B0606; /* dark red background */
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        header .logo {
            display: flex;
            align-items: center;
        }

        header .logo img {
            height: 50px; /* Adjust height as needed */
        }

        header nav {
            display: flex;
        }

        header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            margin-top: 70px; /* Space for fixed header */
            width: 100%;
            justify-content: center; /* Center content horizontally */
        }

        .sidebar {
            width: 250px;
            background-color: #4B0606;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            top: 70px; /* Space for fixed header */
            left: 0;
        }

        .profile-header {
            text-align: center;
            padding: 20px;
        }

        .profile-picture {
            width: 150px; /* Adjust size as needed */
            height: 150px;
            border-radius: 50%;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .profile-name {
            font-weight: bold;
            color: #FFF;
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
        }

        .menu {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        .menu li {
            margin: 20px 0;
        }

        .menu a {
            color: white;
            text-decoration: none;
            font-size: 20px; /* Adjusted font-size */
            font-family: 'Poppins', sans-serif;
            display: block;
            padding: 10px 20px;
        }

        .menu a:hover {
            background-color: #7a5961;
            border-radius: 5px;
        }

        .headerstaff {
            margin-left: 20%;
        }
        
        .main-content {
            flex: 1;
            margin-left: 10%;
            max-width: 70%; /* Adjust the maximum width of the content */
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

    </style>
</head>
<body>
    <?php include 'headerStaffDelivery.html'; ?>
    <div class="container">
        <div class="sidebar">
            <div class="profile-header">
                <div class="profile-name">Hi, LEE CHIN</div>
                <img src="../images/picture.png" alt="Profile Picture" class="profile-picture">
            </div>
            <ul class="menu">
                <li><a href="myProfileStaff.php">Profile</a></li>
                <li><a href="deliverylist.php">Delivery</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="headerstaff">
                <h1>STAFF ID: xxxx</h1>
            </div>
            <table>
                <tr>
                    <th>Tracking ID</th>
                    <th>Recipient</th>
                    <th>Address</th>
                    <th>Proof of Delivery</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>TRK2024FKL123</td>
                    <td>Dolla</td>
                    <td>Lot11, xxx , xxx ,xx</td>
                    <td>Image(x)</td>
                    <td>Out of delivery</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
