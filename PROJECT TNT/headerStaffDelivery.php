<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieve the staff name from the session or set a default value
$staffName = isset($_SESSION['staffName']) ? $_SESSION['staffName'] : 'Guest';

// Database connection
require_once 'dbConnect.php'; // Adjust the path as per your project structure

// Retrieve staffID from session or set a default value
$staffID = isset($_SESSION['staffID']) ? $_SESSION['staffID'] : null;

if ($staffID) {
    // Fetch profile picture path from database
    $selectQuery = "SELECT profilePicture FROM Staff WHERE staffID = ?";
    $stmt = $dbCon->prepare($selectQuery);
    $stmt->bind_param('i', $staffID);
    $stmt->execute();
    $stmt->bind_result($profilePicture);
    $stmt->fetch();
    $stmt->close(); // Close the statement after fetching results
}

// Check if staff position is 'courier'
if ($_SESSION['position'] !== 'courier') {
    echo '<div class="access-denied">Access Denied. Only accessible by courier staff.</div>';
    exit();
}

// Fetch total orders and delivered orders count for progress bar
$sqlTotalOrders = "SELECT COUNT(*) as total FROM ORDERS";
$resultTotal = $dbCon->query($sqlTotalOrders);
$totalOrders = $resultTotal->fetch_assoc()['total'];

$sqlDeliveredOrders = "SELECT COUNT(*) as delivered FROM ORDERS WHERE status = 'Delivered'";
$resultDelivered = $dbCon->query($sqlDeliveredOrders);
$deliveredOrders = $resultDelivered->fetch_assoc()['delivered'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header - TNT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../header.css">
    <script src="sidebar.js" defer></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif; /* Premium font */
            background-color: #f8f9fa; /* Bootstrap default background color */
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #4b0606;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .logo img {
            height: 50px; 
            transition: transform 0.3s, filter 0.3s; /* Add transition for transform and filter */
        }

        .logo img:hover {
            transform: scale(1.1); /* Scale up on hover */
            filter: brightness(1.2); /* Slightly brighten on hover */
        }

        .logo span {
            font-size: 250%;
            cursor: pointer;
            margin-top: -30%;
            margin-right: 10px; /* Ensure it stays on top */
            color: white;
            transition: transform 0.3s, font-size 0.3s; /* Added transition for transform and font-size */
        }

        .logo span:hover {
            transform: scale(2); /* Enlarge icon on hover */
            font-size: 270%; /* Increase font size on hover */
            color: goldenrod;
        }

        nav {
            flex-grow: 1; /* Makes the nav take up the remaining space */
            display: flex;
            justify-content: flex-end; /* Aligns items to the right */
        }

        nav a {
            text-decoration: none;
            color: white;
            margin-left: 20px;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s, transform 0.3s; /* Added transition for transform */
        }

        nav a:hover {
            color: #ffcc00;
            transform: translateY(-3px); /* Bounce effect on hover */
            text-decoration: none; /* Remove underline on hover */
        }

        .logout img {
            height: 40px;
            transition: transform 0.3s, filter 0.3s; /* Add transition for transform and filter */
        }

        .logout img:hover {
            transform: scale(1.1); /* Scale up on hover */
            filter: brightness(2); /* Slightly brighten on hover */
        }

        .logout img:active {
            transform: scale(0.9); /* Scale down on click */
            filter: brightness(0.9); /* Slightly darken on click */
        }

        .sidebar {
            width: 250px;
            background-color: #4B0606;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            top: 70px; /* Space for fixed header */
            left: -250px; /* Start off-screen */
            transition: left 0.3s ease; /* Smoothly transition left position */
        }

        .sidebar.open {
            left:0; /* Show sidebar when 'open' class is applied */
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
            object-fit: cover;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .profile-picture:hover {
            transform: scale(1.1); /* Scale up the image on hover */
        }

        .profile-name {
            font-weight: bold;
            color: #FFF;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .menu {
            padding: 0;
        }

        .menu li {
            list-style-type: none;
            padding: 10px 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .menu li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 10px;
        }

        .menu li a:hover {
            background-color: #E1E7E0; /* Hover background color */
            color: #4B0606; /* Text color on hover */
            transform: translateY(-3px); /* Bounce effect on hover */
            text-decoration: none; /* Remove underline on hover */
        }

        .menu li.active a {
            background-color: #b30000; /* Slightly lighter red */
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <span id="menu-toggle" onclick="toggleSidebar()">&#9776;</span>
        </div>
        <div class="logo">
        <a href="deliverylist.php">
            <img src="images/tntlogo.png" alt="TNT Logo">
        </a>
        </div>
        <nav>
            <div class="logout">
            <a href="logout.php">
                <img src="images/logout.png" alt="Logout Icon">
            </a>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="profile-header">
            <div class="profile-name">Hi, <?php echo htmlspecialchars($staffName); ?></div>
            <form id="profile-picture-form" action="uploadProfilePicture.php" method="post" enctype="multipart/form-data">
                <label for="profile-picture-upload">
                    <?php if ($profilePicture): ?>
                        <img id="profile-picture-preview" src="<?php echo $profilePicture; ?>" alt="Profile Picture" class="profile-picture">
                    <?php else: ?>
                        <img id="profile-picture-preview" src="images/default_profile.png" alt="Profile Picture" class="profile-picture"> <!-- Default image if no profile picture found -->
                    <?php endif; ?>
                </label>
                <input type="file" id="profile-picture-upload" name="profile_picture" accept="image/*" style="display: none;">
                <button type="submit" id="submit-profile-picture" style="display: none;">Upload</button>
            </form>
        </div>
        <ul class="menu">
            <li><a href="myProfileStaff.php">Profile</a></li>
            <li><a href="deliverylist.php">Delivery</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <!-- Your main content goes here -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to toggle sidebar
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
</body>
</html>
