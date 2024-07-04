<?php
session_start();
include '../dbConnect.php';

$errorMessage = ''; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffID = $_POST['userid'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM STAFF WHERE staffID = ? AND password = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("ss", $staffID, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Staff found, set session with all staff details
        $row = $result->fetch_assoc();
        $_SESSION['staffID'] = $row['staffID'];
        $_SESSION['staffName'] = $row['staffName'];
        $_SESSION['staffPhone'] = $row['staffPhone'];
        $_SESSION['staffEmail'] = $row['staffEmail'];
        $_SESSION['position'] = $row['position'];
        $_SESSION['branchID'] = $row['branchID'];

        // Check position for access control
        if ($_SESSION['position'] == 'courier') {
            header("Location: ../StaffDelivery/deliverylist.php");
            exit();
        } else {
            // Redirect to appropriate page for other positions
            // Example:
            // header("Location: dashboard.php");
            // exit();
        }
    } else {
        $errorMessage = "Invalid credentials."; // Set error message
    }
}
?>

<?php include '../universalHeader.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ece0d1;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            border-radius: 10px;
            background-color: #4b0606;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
            padding: 20px;
            width: 50%;
            position: relative; /* For animation purposes */
        }
        .btn-close {
            background-color: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
            position: absolute;
            right: 10px;
            top: 10px;
            transition: transform 0.3s ease; /* Animation for close button */
        }
        .btn-close:hover {
            transform: scale(1.2); /* Scale up effect on hover */
        }
        .form-container h2 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }
        .form-container label {
            color: white;
            margin-bottom: 5px;
            text-align: left;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .button-confirm button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #b45858;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease; /* Smooth background color transition */
        }
        .button-confirm button:hover {
            background-color: #45a049;
        }
        .form-container a {
            text-decoration: none;
            color: #cccccc;
            font-size: 14px;
            transition: color 0.3s ease; /* Smooth color transition */
        }
        .form-container a:hover {
            text-decoration: underline;
            color: white; /* Change text color on hover */
        }
        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container border rounded shadow-sm p-4">
        <button class="btn btn-outline-light btn-sm close-btn">&times;</button>
        <h2 class="text-center text-white mb-4">Welcome Back</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="userid" class="text-white">User ID</label>
                <input type="text" class="form-control" id="userid" name="userid">
            </div>
            <div class="form-group">
                <label for="password" class="text-white">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">LOG IN</button>
            </div>
        </form>
        <div class="d-flex justify-content-between mt-3">
            <a href="signup.php" class="text-white pulse-link">Don't have an account?</a>
            <a href="forgotPassword.php" class="text-white pulse-link">Forgot password</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Handle close button click
    document.querySelector('.close-btn').addEventListener('click', function() {
        window.location.href = 'homepage.php';
    });

    // Add pulse effect to links on hover
    const pulseLinks = document.querySelectorAll('.pulse-link');
    pulseLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.classList.add('text-white', 'font-weight-bold');
        });
        link.addEventListener('mouseleave', function() {
            this.classList.remove('text-white', 'font-weight-bold');
        });
    });
</script>
</body>
</html>
