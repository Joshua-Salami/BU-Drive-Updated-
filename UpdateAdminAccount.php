<?php
include 'connect.php';

$adminId = $_GET['updateId'];

$getAdminDetails = "SELECT * FROM admins WHERE adminId = $adminId";
$getAdminDetailsResult = mysqli_query($conn, $getAdminDetails);


$row = mysqli_fetch_assoc($getAdminDetailsResult);

$previousFullName = htmlspecialchars($row['fullName']);
$previousEmail = htmlspecialchars($row['email']);

if(isset($_POST['submit'])){
    $fullName = $_POST['fName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $insertQueue = "UPDATE admins SET fullName = '$fullName', email = '$email', password = '$password' WHERE adminId = $adminId";

    if($conn->query($insertQueue)==TRUE){
        header("Location: ./Profile.php");
        exit();
    }
    else{
        echo "Error Updating admins:".$conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Based E-Learning Platform for Babcock Students </title>
    <link rel="stylesheet" href="CSS/SignpUp.css">

</head>
<body>
    <div class="Container"> 
        <h2> Welcome to BU-Drive </h2>
        <p class="subtitle"> One place for everything. </p>
        
        <form id="SignUp-form" method="post">
            <input type="text" id="fullname" name="fName" placeholder="Full Name (Surname + Firstname)" value="<?php echo $previousFullName; ?>" required> <br>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $previousEmail; ?>" required> <br>

            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <img src="Images/hide.png" alt="Toggle Password" class="eye-icon" onclick="togglePassword()">
                <div class="password-container">
                    <input type="password" id="confirm-password" placeholder="Confirm Password" required>
                    <img src="Images/hide.png" alt="Toggle Password" class="eye-icon" onclick="togglePassword()">
                    <p id="passwordError" style="color: red; display: none;">Passwords do not match</p>
                </div>             
            </div>
        </form>
    </div>
    <button type="submit" name="submit"> Update Account </button>

    <script>
        let registerForm = document.getElementById('SignUp-form')
        let password = document.getElementById('password')
        let confirmPassword = document.getElementById('confirm-password')
        let passwordError = document.getElementById("passwordError")

        registerForm.addEventListener('submit', function(event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault();
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });
    </script>

    <script src="JS/function.js"></script>
</body>
</html>