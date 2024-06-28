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
            margin-top: 10%;
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
        .button-close .btn-close {
            position: absolute;
            background-color: transparent;
            border: none;
            font-size: 40px;
            cursor: pointer;
            right: 4px;
            top: 2px;
            color: white;
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
            width: 40%;
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
        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    </style>
    
<div class="container">
    <div class="form-container">
        <div class="button-close">
            <button class="btn-close">&times;</button>
        </div>
        <h2>Welcome Back</h2>
        <form action="login.php" method="post">
            <label for="userid">User ID</label>
            <input type="text" id="userid" name="userid">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <div class="button-confirm">
                <button type="submit">LOG IN</button>
            </div>
        </form>
        <div class="form-footer">
            <a href="signup.php">Don't have an account?</a>
            <a href="forgotPassword.php">Forgot password</a>
        </div>
    </div>
</div>

<script>
    document.querySelector('.btn-close').addEventListener('click', function() {
        window.location.href = 'homepage.php';
    });
</script>
</body>
</html>

<?php
// login.php
session_start();
include '../dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_POST['userid'];
    $password = $_POST['password'];

    $sql = "SELECT staffID, staffName FROM STAFF WHERE staffID = ? AND password = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("ss", $staffID, $password); // Changed to "ss" to bind both as strings
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Staff found, set session
        $row = $result->fetch_assoc();
        $_SESSION['staffID'] = $row['staffID'];
        $_SESSION['staffName'] = $row['staffName'];
        header("Location: deliverylist.php");
        exit();
    } else {
        echo "Invalid credentials.";
    }
}
?>
