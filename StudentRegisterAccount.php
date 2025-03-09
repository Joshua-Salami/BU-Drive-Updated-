<?php
include 'connect.php';
session_start();

$fullName = $_POST['fName'];
$email = $_POST['email'];
$course = $_POST['course'];
$level = $_POST['level'];
$password = $_POST['password'];
$password = md5($password);
$role = "Student";

$checkEmail = "SELECT * FROM students WHERE email='$email'";
$result = $conn->query($checkEmail);

if ($result->num_rows > 0) {
    echo "Email Address Already Exists!";
} else {
    $insertQueue = "INSERT INTO students (fullName, email, course, level, password, role) 
                    VALUES ('$fullName', '$email', '$course', '$level', '$password', '$role')";

    if ($conn->query($insertQueue) === TRUE) {
        header("Location: ./LoginAsStudent.html");
        exit();
    } else {
        echo "Error inserting into students: " . $conn->error;
    }
}
?>