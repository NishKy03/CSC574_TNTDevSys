<?php
session_start();
include('CHeader.php');
if (!isset($_SESSION['staffID'])) {
    header("Location: login.php");
    exit();
}

$c_id = $c_pw = $c_name = $c_hpno = $c_email = $c_security_question = $c_security_answer = "";
$pw_err = $name_err = $hpno_err = $email_err = $security_question_err = $security_answer_err = "";

// Function to fetch user data
function fetchUserData($dbCon, $staffID) {
    $sql = "SELECT staffID, password, staffName, staffPhone, staffEmail, staffQuestion, staffAnswer FROM staff WHERE staffID = ?";
    if ($stmt = mysqli_prepare($dbCon, $sql)) {
        mysqli_stmt_bind_param($stmt, "d", $staffID);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                return mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
        }
        mysqli_stmt_close($stmt);
    }
    return null;
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty(trim($_POST["id"]))) {
    $c_id = $_POST["id"];

    $input_pw = trim($_POST["pw"]);
    if (empty($input_pw)) {
        $pw_err = "Please enter a password.";
    } else if (!filter_var($input_pw, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^.{6,}$/")))) {
        $pw_err = "Your password must be 6 characters or longer.";
    } else {
        $c_pw = $input_pw;
    }

    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } else if (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s\.\']+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $c_name = $input_name;
    }

    // Validate phone number
    $input_hpno = trim($_POST["phone"]);
    if (empty($input_hpno)) {
        $hpno_err = "Please enter a phone number.";
    } else if (!filter_var($input_hpno, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]{3}-[0-9]+$/")))) {
        $hpno_err = "Invalid phone number. Please use XXX-XXXXXXX format.";
    } else {
        $c_hpno = $input_hpno;
    }

    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } else if (!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/")))) {
        $email_err = "Invalid email. Please use XXX@XXX.XXX format.";
    } else {
        $c_email = $input_email;
    }

    $c_security_question = $_POST["security_question"];
    if (empty($c_security_question)) {
        $security_question_err = "Please select a security question.";
    }

    $c_security_answer = trim($_POST["security_answer"]);
    if (empty($c_security_answer)) {
        $security_answer_err = "Please enter an answer to the security question.";
    }

    // Check input errors before updating in database
    if (empty($pw_err) && empty($name_err) && empty($hpno_err) && empty($email_err) && empty($security_question_err) && empty($security_answer_err)) {
        $sql = "UPDATE staff SET password = ?, staffName = ?, staffPhone = ?, staffEmail = ?, staffQuestion = ?, staffAnswer = ? WHERE staffID = ?";
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssssd", $c_pw, $c_name, $c_hpno, $c_email, $c_security_question, $c_security_answer, $c_id);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success_message'] = "Profile updated successfully.";
            } else {
                $_SESSION['error_message'] = "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}

// Fetch user data (for both GET and POST requests)
if (isset($_SESSION['staffID']) && !empty($_SESSION['staffID'])) {
    $userData = fetchUserData($dbCon, $_SESSION['staffID']);
    if ($userData) {
        $c_id = $userData["staffID"];
        $c_pw = $userData["password"];
        $c_name = $userData["staffName"];
        $c_hpno = $userData["staffPhone"];
        $c_email = $userData["staffEmail"];
        $c_security_question = $userData["staffQuestion"];
        $c_security_answer = $userData["staffAnswer"];
    }
}

mysqli_close($dbCon);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <title>Profile Page</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Poppins", sans-serif;
            background: #F3EDE0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100%;
        }
        .myprofile-container {
            background: #4b0606;
            padding: 30px;
            padding-top: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;        
        }
        .myprofile-header {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            padding-right: auto;
            padding-left: 36%;
        }
        .myprofile-header h1 {
            margin: 0;
            color: white;
        }
        .myprofile-form {
            display: flex;
            flex-direction: column;
        }
        .myprofile-form label {
            margin-top: 10px;
            font-weight: bold;
            color: white;
        }
        .myprofile-form input, .myprofile-form select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        .myprofile-form input[type="submit"] {
            margin-top: 20px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #56c4e1;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .myprofile-form input[type="submit"]:hover {
            background: #45a2b9;
        }
        span.error {
            color: red;
            font-size: 14px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script>
        function drawAlert() {
            return Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update this record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                return result.isConfirmed;
            });
        }

        // Function to show success message
        function showSuccessMessage(message) {
            Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#3085d6'
            });
        }

        // Function to show error message
        function showErrorMessage(message) {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#d33'
            });
        }
    </script>
</head>
<body>
<div class="container">
        <div class="myprofile-container">
            <div class="myprofile-header">
            <h1>PROFILE</h1>
            </div>
            <div class="myprofile-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="profileForm">
                    <label for="id">ID</label>
                    <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($c_id); ?>" readonly>

                    <label for="pw">Password</label>
                    <input type="password" id="pw" name="pw" value="<?php echo htmlspecialchars($c_pw); ?>">
                    <span class="error"><?php echo $pw_err; ?><br></span>

                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($c_name); ?>">
                    <span class="error"><?php echo $name_err; ?><br></span>

                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($c_hpno); ?>">
                    <span class="error"><?php echo $hpno_err; ?><br></span>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($c_email); ?>">
                    <span class="error"><?php echo $email_err; ?><br></span>

                    <label for="security_question">Security Question</label>
                    <select id="security_question" name="security_question">
                        <option value="">Select a security question</option>
                        <option value="childhood_nickname" <?php if ($c_security_question === "childhood_nickname") echo "selected"; ?>>What was your childhood nickname?</option>
                        <option value="favorite_childhood_friend" <?php if ($c_security_question === "favorite_childhood_friend") echo "selected"; ?>>What is the name of your favorite childhood friend?</option>
                        <option value="oldest_sibling_birthday" <?php if ($c_security_question === "oldest_sibling_birthday") echo "selected"; ?>>What is your oldest sibling's birthday month and year? (e.g., January 1900)</option>
                        <option value="pet_name" <?php if ($c_security_question === "pet_name") echo "selected"; ?>>What is your pet's name?</option>
                        <option value="favorite_artist" <?php if ($c_security_question === "favorite_artist") echo "selected"; ?>>Who is your favorite artist?</option>
                    </select>
                    <span class="error"><?php echo $security_question_err; ?><br></span>

                    <label for="security_answer">Security Answer</label>
                    <input type="text" id="security_answer" name="security_answer" value="<?php echo htmlspecialchars($c_security_answer); ?>">
                    <span class="error"><?php echo $security_answer_err; ?><br></span>

                    <br><input type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>
    <?php 
            // Show SweetAlert messages
            if (isset($_SESSION['success_message'])) {
                echo "<script>showSuccessMessage('" . addslashes($_SESSION['success_message']) . "');</script>";
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error_message'])) {
                echo "<script>showErrorMessage('" . addslashes($_SESSION['error_message']) . "');</script>";
                unset($_SESSION['error_message']);
            }
    ?>
    <script>
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            drawAlert().then((confirmed) => {
                if (confirmed) {
                    this.submit();
                }
            });
        });
    </script>
</body>
</html>

