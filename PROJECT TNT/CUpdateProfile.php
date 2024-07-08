<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('CHeader.php');

if (!isset($_SESSION['staffID'])) {
    header("Location: login.php");
    exit();
}

$c_pw = $c_name = $c_hpno = $c_email = $c_security_question = $c_security_answer = "";
$pw_err = $name_err = $hpno_err = $email_err = $security_question_err = $security_answer_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty(trim($_POST["id"]))) {
    $c_id = $_POST["id"];

    // Validate password
    $input_pw = trim($_POST["pw"]);
    if (empty($input_pw)) {
        $pw_err = "Please enter a password.";
    } elseif (!filter_var($input_pw, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^.{6,}$/")))) {
        $pw_err = "Your password must be 6 characters or longer.";
    } else {
        $c_pw = $input_pw;
    }

    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s\.\']+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $c_name = $input_name;
    }

    // Validate phone number
    $input_hpno = trim($_POST["phone"]);
    if (empty($input_hpno)) {
        $hpno_err = "Please enter a phone number.";
    } elseif (!filter_var($input_hpno, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]{3}-[0-9]+$/")))) {
        $hpno_err = "Invalid phone number. Please use XXX-XXXXXXX format.";
    } else {
        $c_hpno = $input_hpno;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
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
    } else {
        // Store error messages in session
        $_SESSION['errors'] = array(
            'pw_err' => $pw_err,
            'name_err' => $name_err,
            'hpno_err' => $hpno_err,
            'email_err' => $email_err,
            'security_question_err' => $security_question_err,
            'security_answer_err' => $security_answer_err
        );
    }

    mysqli_close($dbCon);
}

// Always redirect back to CProfile.php, whether there were errors or not
header("Location: CProfile.php");
exit();