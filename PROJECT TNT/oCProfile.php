<?php
include('CHeader.php');
if (!isset($_SESSION['staffID'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>
<?php
// Define variables and initialize with empty values
$c_pw = $c_name = $c_hpno = $c_email = $c_security_question = $c_security_answer = "";
$pw_err = $name_err = $hpno_err = $email_err = $security_question_err = $security_answer_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty(trim($_POST["id"]))) { 
    $c_id = $_POST["id"];

    // Validate password
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

    // Validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } else if (!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/")))) {
        $email_err = "Invalid email. Please use XXX@XXX.XXX format.";
    } else {
        $c_email = $input_email;
    }

    // Validate security question and answer
    $input_security_question = trim($_POST["security_question"]);
    if (empty($input_security_question)) {
        $security_question_err = "Please select a security question.";
    } else {
        $c_security_question = $input_security_question;
    }

    $input_security_answer = trim($_POST["security_answer"]);
    if (empty($input_security_answer)) {
        $security_answer_err = "Please enter an answer.";
    } else {
        $c_security_answer = $input_security_answer;
    }

    // Check input errors before updating in database
    if (empty($pw_err) && empty($name_err) && empty($hpno_err) && empty($email_err) && empty($security_question_err) && empty($security_answer_err)) {
        // Prepare an update statement
        $sql = "UPDATE staff SET password = ?, staffName = ?, staffPhone = ?, staffEmail = ?, staffQuestion = ?, staffAnswer = ? WHERE staffID = ?";
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssd", $param_pw, $param_name, $param_hpno, $param_email, $param_security_question, $param_security_answer, $param_id);

            // Set parameters
            $param_pw = $c_pw;
            $param_name = $c_name;
            $param_hpno = $c_hpno;
            $param_email = $c_email;
            $param_security_question = $c_security_question;
            $param_security_answer = $c_security_answer;
            $param_id = $c_id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                header("location: CDashboard.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($dbCon);
} else {
    if (isset($_SESSION['staffID']) && !empty($_SESSION['staffID'])) {
        // Get URL parameter
        $c_id = trim($_SESSION['staffID']);

        // Prepare a select statement
        $sql = "SELECT staffID, password, staffName, staffPhone, staffEmail, staffQuestion, staffAnswer FROM staff WHERE staffID = ?";
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "d", $param_id);
            
            // Set parameters
            $param_id = $c_id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $c_id = $row["staffID"];
                    $c_pw = $row["password"];
                    $c_name = $row["staffName"];
                    $c_hpno = $row["staffPhone"];
                    $c_email = $row["staffEmail"];
                    $c_security_question = $row["staffQuestion"];
                    $c_security_answer = $row["staffAnswer"];
                } else {
                    header("location: CProfile.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($dbCon);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
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
            padding-top: 100px;
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
        span {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
    function drawAlert() {
        var answer = confirm("Are you sure to update this record?");
        if (!answer)
            return false;
    }
</script>
</head>
<body>
    <div class="container">
        <div class="myprofile-container"><br><br>
            <div class="myprofile-header">
                <h1>PROFILE</h1>
            </div>
            <div class="myprofile-form">
                <form action="CProfile.php" method="post" onSubmit="return drawAlert();">
                    <label for="id">ID</label>
                    <input type="text" id="id" name="id" value="<?php echo $c_id; ?>" readonly>

                    <label for="pw">Password</label>
                    <input type="password" id="pw" name="pw" value="<?php echo $c_pw; ?>">
                    <span><?php echo $pw_err."<br>"; ?></span>

                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $c_name; ?>">
                    <span><?php echo $name_err."<br>"; ?></span>

                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $c_hpno; ?>">
                    <span><?php echo $hpno_err."<br>"; ?></span>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $c_email; ?>">
                    <span><?php echo $email_err."<br>"; ?></span>

                    <label for="security_question">Security Question</label>
                    <select id="security_question" name="security_question">
                        <option value="">Select a security question</option>
                        <option value="childhood_nickname" <?php if ($c_security_question === "childhood_nickname") echo "selected"; ?>>What was your childhood nickname?</option>
                        <option value="favorite_childhood_friend" <?php if ($c_security_question === "favorite_childhood_friend") echo "selected"; ?>>What is the name of your favorite childhood friend?</option>
                        <option value="oldest_sibling_birthday" <?php if ($c_security_question === "oldest_sibling_birthday") echo "selected"; ?>>What is your oldest sibling’s birthday month and year? (e.g., January 1900)</option>
                        <option value="pet_name" <?php if ($c_security_question === "pet_name") echo "selected"; ?>>What is your pet's name?</option>
                        <option value="favorite_artist" <?php if ($c_security_question === "favorite_artist") echo "selected"; ?>>Who is your favorite artist?</option>
                    </select>
                    <span><?php echo $security_question_err."<br>"; ?></span>

                    <label for="security_answer">Security Answer</label>
                    <input type="text" id="security_answer" name="security_answer" value="<?php echo $c_security_answer; ?>">
                    <span><?php echo $security_answer_err."<br>"; ?></span>

                    <br><input type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>
</body>
</html>