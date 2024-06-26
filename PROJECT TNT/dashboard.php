<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Navigation</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="nav_bar">
        <nav class="top_nav">
            <div class="logo">
                <span id="menu-toggle" onclick="toggleSidebar()">&#9776;</span>
                <img src="tnt_logo.png">
            </div>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>   
        </nav>
    </div>
    <div class="sidebar" id="sidebar">
        <div class="profile">
            <img src="profile_pic.jpg" alt="Profile Picture">
            <h2>LEE CHIN</h2>
        </div>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="staff_list.php">Staff</a></li>
            </ul>
        </nav>
    </div>
    <div class="main-content" id="main-content">
        <!-- Main content will go here -->
    </div>
</body>
</html>
