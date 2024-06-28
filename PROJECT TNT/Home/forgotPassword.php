<?php include 'universalHeader.php'; ?>
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ece0d1;
        }
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top:5%;
        }
        .button-close .btn-close {
            background-color: transparent;
            border: none;
            font-size: 40px;
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 5px;
            color: white;
        }
        .form-container {
            position: relative;
            border: none;
            padding: 20px;
            border-radius: 10px;
            background-color: #4b0606;
            width: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
        }
        .form-container h2 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: white;
            margin-left: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .button-confirm button {
            width: 50%;
            padding: 10px;
            margin-top: 10px;
            background-color: #b45858;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 25px;
            font-weight: bold;
        }
        .button-confirm button:hover {
            background-color: #45a049;
        }
        .form-container a {
            text-decoration: none;
            color: #cccccc;
            font-size: 14px;
        }
        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
<div class="container">
    <div class="form-container">
        <div class="button-close">
            <button class="btn-close">&times;</button>
        </div>
        <h2>Change Password</h2>
        <label for="userid">User ID</label>
        <input type="text" id="userid" name="userid">
        <label for="newpassword">New Password</label>
        <input type="password" id="newpassword" name="newpassword">
        <label for="conpassword">Confirm Password</label>
        <input type="password" id="conpassword" name="conpassword">
        <div class="button-confirm">
            <button type="submit">CONFIRM</button>
        </div>
    </div>
</div>

</body>
</html>
