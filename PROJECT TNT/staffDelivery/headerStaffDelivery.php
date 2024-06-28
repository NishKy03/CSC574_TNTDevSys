<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieve the staff name from the session or set a default value
$staffName = isset($_SESSION['staffName']) ? $_SESSION['staffName'] : 'Guest';

// Database connection
require_once '../dbConnect.php'; // Adjust the path as per your project structure

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../header.css">
    <script src="sidebar.js" defer></script>
    <title>Header - TNT</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #4b0606;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 50px;
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
        }

        nav a:hover {
            color: #ffcc00;
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
        }

        .profile-name {
            font-weight: bold;
            color: #FFF;
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
        }

        .logo span {
            font-size: 250%;
            cursor: pointer;
            margin-top: -30%;
            margin-right: 10px; /* Ensure it stays on top */
            color: white;
        }

        .menu {
            padding: 0;
        }

        .menu li {
            list-style-type: none;
            padding: 10px 20px;
        }

        .menu li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 10px;
            transition: background-color 0.3s, color 0.3s;
        }

        .menu li a:hover {
            background-color: #E1E7E0; /* Hover background color */
            color: #4B0606; /* Text color on hover */
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
            <img src="../images/tntlogo.png" alt="TNT Logo">
        </div>
        <nav>
            <a href="deliverylist.php">HOME</a>
            <a href="../logout.php">Log Out</a>
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
                        <img id="profile-picture-preview" src="../images/default_profile.png" alt="Profile Picture" class="profile-picture"> <!-- Default image if no profile picture found -->
                    <?php endif; ?>
                    <div class="change-profile-picture">Change Picture</div>
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

</body>
</html>
