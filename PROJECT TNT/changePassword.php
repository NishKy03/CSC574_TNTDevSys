<?php
session_start();
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_SESSION['staffID'];
    $securityAnswer = $_POST['securityAnswer'];
    
    // Verify the security answer
    $sql = "SELECT * FROM STAFF WHERE staffID = ? AND staffAnswer = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("ss", $staffID, $securityAnswer);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        // Security answer is correct, allow password change
        header("Location: changePassword.php");
        exit();
    } else {
        $_SESSION['errorMessage'] = "Incorrect answer.";
        header("Location: answerSecurityQuestion.php");
        exit();
    }
}
?>

<?php include 'universalHeader.php'; ?>
<title>Change Password</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #ece0d1;
    }
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .form-container {
        position: relative;
        background-color: #4b0606;
        padding: 30px;
        border-radius: 10px;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    .form-container h2 {
        color: white;
        margin-bottom: 20px;
        font-size: 30px;
    }
    .form-container label {
        text-align: left;
        color: white;
    }
    .form-container input[type="text"],
    .form-container input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }
    .button-confirm button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        background-color: #b45858;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        transition: background-color 0.3s ease;
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
    .button-close {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .btn-close {
        background-color: transparent;
        border: none;
        font-size: 24px;
        color: white;
        cursor: pointer;
        transition: transform 0.3s ease, font-size 0.3s ease;
    }
    .btn-close:hover {
        transform: scale(1.2);
        font-size: 28px; /* This line will help the button to enlarge */
    }
</style>
<div class="container">
    <div class="form-container">
        <div class="button-close">
            <button class="btn-close">&times;</button>
        </div>
        <h2>Change Password</h2>
        <form id="changePasswordForm" action="updatePassword.php" method="POST">
            <div class="form-group">
                <label for="newpassword">New Password</label>
                <input type="password" class="form-control" id="newpassword" name="newpassword" required>
            </div>
            <div class="form-group">
                <label for="conpassword">Confirm Password</label>
                <input type="password" class="form-control" id="conpassword" name="conpassword" required>
            </div>
            <div class="button-confirm">
                <button type="submit" class="btn">CONFIRM</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.querySelector('.btn-close').addEventListener('click', function() {
        window.history.back();
    });
</script>
</body>
</html>
