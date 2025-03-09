<?php

session_start();

include 'connect.php';


$adminId = $_SESSION['adminId'];

$postTitle=$_POST['pTitle'];
$post=$_POST['post'];
$creationDate = date('Y-m-d');
$image=$_FILES['image']['tmp_name'];
$imgContent = addslashes(file_get_contents($image));

$insertQueue = "INSERT INTO posts (adminId, postTitle, post, creationDate, image) VALUES ('$adminId', '$postTitle', '$post','$creationDate','$imgContent')";

if ($conn->query($insertQueue) === TRUE) {
    header("Location: Profile.php");
    exit();
}else{
    echo "Error inserting into posts table: " . $conn->error;
}?>