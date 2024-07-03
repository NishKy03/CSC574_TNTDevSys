<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #4b0a05;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            padding: 0 20px;
        }
        .logo-link {
            text-decoration: none;
            
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        .circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #4b0606;
            color: #ff6600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin: -2px;
            border: 4.5px solid #ff6600;
            font-family: Verdana, sans-serif;
            font-weight: bold;
            transition: transform 0.3s ease; /* Animation for circle */
        }
        .circle:hover {
            transform: scale(1.5); /* Scale up effect on hover */
        }
        .navbar-links a {
            color: white;
            text-decoration: none;
            padding: 10px 10px;
            transition: background-color 0.3s ease;
            font-family: Verdana, sans-serif;
            font-weight: bold;
            font-size: 18px;
            position: relative;
        }
        .navbar-links a:hover {
            background-color: #ddd;
            color: black;
        }
        .navbar-links a::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            bottom: 0;
            left: 0;
            background-color: #ff6600;
            transform: scaleX(0); /* Initially hidden */
            transition: transform 0.3s ease;
        }
        .navbar-links a:hover::before {
            transform: scaleX(1); /* Expand underline on hover */
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="homepage.php" class="logo-link">
            <div class="logo-container">
                <div class="circle">T</div>
                <div class="circle">N</div>
                <div class="circle">T</div>
            </div>
        </a>
        <div class="navbar-links">
            <a href="../Project TNT/index.php">HOME</a>
            <a href="../Project TNT/Home/contactUs.php">CONTACT</a>
            <a href="../Home/tracking.php">TRACKING</a>
            <a href="../Home/login.php">LOGIN</a>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
