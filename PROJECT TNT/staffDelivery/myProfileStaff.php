<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../header.css">
    <title>Profile - TNT</title>
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

        .profile-content {
            flex: 1;
            padding: 20px;
            margin-left: 15%;
        }

        .profile-details {
        background-color: rgba(75, 6, 6, 0.5);
        padding: 20px;
        border-radius: 20px;
        width: 90%;
        height: 80%;
        flex-shrink: 0;
        margin: auto;
        }

        .profile-details h1 {
            display: flex;
            width: 105%;
            flex-direction: column;
            justify-content: center;
            flex-shrink: 0;
            color: #FFF;
            text-align: center;
            font-family: Poppins;
            font-size: 64px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;
        }

        .profile-info {
            display: flex;
            flex-direction: column;   
        }

        .profile-info label {
            display: flex;
            width: 174px;
            height: 29px;
            flex-direction: column;
            justify-content: center;
            flex-shrink: 0;
            color: #FFF;
            font-family: Roboto;
            font-size: 18px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;
            margin-left: 50px;
        }

        .profile-info input {
            display: flex;
            justify-content: center;
            width: 90%;
            height: 30px;
            background:  #FFF;
            border-radius: 20px;
            margin-left:3%;
        }

        .profile-info button {
            border-radius: 10px;
            background-color: #B45858;
            width: 245px;
            height: 70px;
            flex-shrink: 0;
            margin-top: 3%;
            margin-left: 70%;
            /*text*/
            display: flex;
            justify-content: center;
            flex-shrink: 0;
            color: #FFF;
            text-align: center;
            font-family: Roboto;
            font-size: 48px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;

        }

        .profile-info button:hover {
            background-color: #4B0606;
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
                <li><a href="#">Profile</a></li>
                <li><a href="deliverylist.php">Delivery</a></li>
            </ul>
            </div>
 
        <div class="profile-content">
            <div class="profile-details">
                <h1>PROFILE</h1>
                <div class="profile-info">
                    <label for="id">ID</label>
                    <input type="text" id="id">

                    <label for="name">Name</label>
                    <input type="text" id="name">

                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone">

                    <label for="email">Email</label>
                    <input type="email" id="email"`>

                    <button type="button">UPDATE</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
