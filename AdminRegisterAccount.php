<?php
include 'connect.php';
session_start();

$fullName = $_POST['fName'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);
$role = "Admin";

$checkEmail = "SELECT * FROM admins WHERE email='$email'";
$result = $conn->query($checkEmail);

if ($result->num_rows > 0) {
    echo "Email Address Already Exists!";
} else {
    $insertQueue = "INSERT INTO admins (fullName, email, password, role) 
                    VALUES ('$fullName', '$email', '$password', '$role')";

    if ($conn->query($insertQueue) === TRUE) {
        header("Location: ./LoginAsAdmin.html");
        exit();
    } else {
        echo "Error inserting into students: " . $conn->error;
    }
}
?>