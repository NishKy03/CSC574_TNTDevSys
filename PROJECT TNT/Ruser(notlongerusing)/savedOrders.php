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

        .main-content {
            flex: 1;
            margin-left: 250px; /* Space for sidebar */
            padding: 20px;
            padding-top: 70px; /* Space for fixed header */
        }

        .tracking-container {
            display: flex;
            flex-direction: column; /* Arrange items vertically */
            align-items: center; /* Center items horizontally */
            text-align: center; /* Center text within the container */
        }

        .tracking-container > div {
            margin-bottom: 10px; /* Add space between h1 and input */
            display: flex; /* Align elements horizontally */
            align-items: center; /* Center elements vertically */
        }

        .tracking-container h1 {
            margin-right: 10px; /* Add space between h1 and input */
        }

        .tracking-container input {
            flex: 1; /* Allow input to grow and fill available space */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-right: 10px; /* Add space between input and button */
        }

        .tracking-container button {
            padding: 10px 20px;
            border: none;
            background-color: #B45858;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .tracking-container button:hover {
            background-color: #7a5961;
        }

        .details-container {
            max-width: 600px;
            margin: 0 auto 20px;
            background-color: transparent;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .tracking-container h1, .details-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .details-container {
            padding-top: 0;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
        }

        .details td {
            padding: 10px;

            border: 1px solid #ccc;
        }

        .details th {
            background-color: #4B0606;
            color: white;
            font-weight: bold;
            padding: 5px;
        }

        .details td.date {
            font-weight: bold;
            width: 30%;
        }

        .details td.info {
            width: 70%;
        }
    </style>
</head>
<body>
    <?php include 'headerRuser.html'; ?>
    <div class="container">
        <div class="sidebar">
            <div class="profile-header">
                <div class="profile-name">Hi, LEE CHIN</div>
                <img src="../images/picture.png" alt="Profile Picture" class="profile-picture">
            </div>
            <ul class="menu">
                <li><a href="myProfile.php">Profile</a></li>
                <li><a href="savedOrders.php">Saved Orders</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="details-container">
                <h2>Saved Orders</h2>
                <div class="details">
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="orderid">TRK2024FKL123</td>
                                <td class="orderdate">05/04/2024</td>
                                <td class="status">Out for delivery</td>
                            </tr>
                            <tr>
                                <td class="orderid">TRK2024JUA456</td>
                                <td class="orderdate">07/04/2024</td>
                                <td class="status">Arrived at TGG Sorting Centre</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

