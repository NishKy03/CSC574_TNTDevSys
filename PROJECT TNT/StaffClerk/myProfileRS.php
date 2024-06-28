<?php
    include('nav.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background: #F3EDE0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .profile-container {
            background: #CEA660;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            margin-right: 30%;
            margin-left: 40%;
        }
        .profile-header h2 {
            margin: 0;
        }
        .profile-form {
            display: flex;
            flex-direction: column;
        }
        .profile-form label {
            margin-top: 10px;
            font-weight: bold;
        }
        .profile-form input {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        .profile-form button {
            margin-top: 20px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #56c4e1;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .profile-form button:hover {
            background: #45a2b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
            <h1>PROFILE</h1>
            </div>
            <div class="profile-form">
                <label for="id">ID</label>
                <input type="text" id="id" name="id" value="leechin97" readonly>
                
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="LEE CHIN">
                
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="010-2345678">
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="leechin97@gmail.com">
                
                <button type="submit">UPDATE</button>
            </div>
        </div>
    </div>
</body>
</html>
