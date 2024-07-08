<?php
session_start();

// Check if the staffID is set in the session
if (!isset($_SESSION['staffID'])) {
    header("Location: forgotPassword.php");
    exit();
}

// Database connection
require_once 'dbConnect.php';

// Security questions array
$securityQuestions = [
    "childhood_nickname" => "What was your childhood nickname?",
    "childhood_friend" => "What is the name of your favorite childhood friend?",
    "oldest_sibling" => "What is your oldest sibling’s birthday month and year? (e.g., January 1900)",
    "pet_name" => "What is your pet's name?",
    "favorite_artist" => "Who is your favorite artist?"
];

// Fetch the security question for the given staffID
$staffID = $_SESSION['staffID'];
$sql = "SELECT staffQuestion FROM Staff WHERE staffID = ?";
$stmt = $dbCon->prepare($sql);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $questionKey = $row['staffQuestion'];
    $securityQuestion = isset($securityQuestions[$questionKey]) ? $securityQuestions[$questionKey] : "Security question not found.";
} else {
    // Handle case where the security question is not found
    $_SESSION['errorMessage'] = "Security question not found for the given user ID.";
    header("Location: forgotPassword.php");
    exit();
}

$stmt->close();
$dbCon->close();
?>

<?php include 'universalHeader.php'; ?>
<title>Security Question</title>
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
        <h2>Security Question</h2>
        <?php if (isset($_SESSION['wrongAnswer'])): ?>
            <script>
                alert("Wrong Answer, Please try again");
            </script>
            <?php unset($_SESSION['wrongAnswer']); ?>
        <?php endif; ?>
        <form id="securityQuestionForm" action="verifySecurityQuestion.php" method="POST">
            <div class="form-group">
                <label for="securityQuestion">Question:</label>
                <p><?php echo htmlspecialchars($securityQuestion, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="form-group">
                <label for="securityAnswer">Answer:</label>
                <input type="text" class="form-control" id="securityAnswer" name="securityAnswer" required>
            </div>
            <div class="button-confirm">
                <button type="submit" class="btn">NEXT</button>
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
