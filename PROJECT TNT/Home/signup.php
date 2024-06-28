<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ece0d1;
        }
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
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
            width: 400px;
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
        .button-register{
          padding: 10px;
        }
    
        .button-register button {
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
        .button-register button:hover {
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
</head>
<body>
    <?php include 'universalHeader.html'; ?>
<div class="container">
    <div class="form-container">
        <div class="button-close">
            <button class="btn-close">&times;</button>
        </div>
        <h2>Sign Up</h2>
        <label for="userid">User ID</label>
        <input type="text" id="userid" name="userid">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <label for="conpassword">Confirm Password</label>
        <input type="password" id="conpassword" name="conpassword">
        <label for="phoneNum">Phone Number</label>
        <input type="text" id="phoneNum" name="phoneNum">
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
        <div class="button-register">
            <div class="submit">
                <button type="submit">REGISTER</button>
            </div>
            <br>
            <div class="account">
                <a href="login.html">Already have an account?</a>           
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('.btn-close').addEventListener('click', function() {
        window.location.href = 'homepage.html';
    });
</script>
</body>
</html>
