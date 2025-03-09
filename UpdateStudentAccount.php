<?php
include 'connect.php';

$studentId = $_GET['updateId'];

$getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";
$getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);


$row = mysqli_fetch_assoc($getStudentDetailsResult);

$previousFullName = htmlspecialchars($row['fullName']);
$previousEmail = htmlspecialchars($row['email']);
$previousCourse = htmlspecialchars($row['course']);
$previousLevel = htmlspecialchars($row['level']);

if(isset($_POST['submit'])){
    $fullName = $_POST['fName'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $level = $_POST['level'];
    $password = $_POST['password'];
    $password = md5($password);

    $insertQueue = "UPDATE students SET fullName = '$fullName', email = '$email', course = '$course', level = '$level', password = '$password' WHERE studentId = $studentId";

    if($conn->query($insertQueue)==TRUE){
        header("Location: ./Profile.php");
        exit();
    }
    else{
        echo "Error Updating students:".$conn->error;
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
        
        <form id="registerForm" method="post">
            <input type="text" id="fullname" name="fName" placeholder="Full Name (Surname + Firstname)" value="<?php echo $previousFullName; ?>" required> <br>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $previousEmail; ?>" required> <br>
            <p id="emailError" style="color: red; display: none;">Use Babcock Student Email</p>
            <label for="course">Select Course of Study</label>
            <select id="Course" name="course">
                <option <?php if ($previousCourse == 'CS'){ echo 'selected'; ?> value="CS" <?php }?>> Computer Science (CS)</option>
                <option <?php if ($previousCourse == 'IT'){ echo 'selected'; ?> value="IT" <?php }?>> Information Technology (IT) </option>
                <option <?php if ($previousCourse == 'CT'){ echo 'selected'; ?> value="CT" <?php }?>> Computer Technology (CT) </option>
            </select> <br>

            <label for="level">Select Level</label>
            <select id="Level" name="level">
                <option <?php if ($previousLevel == '100L'){ echo 'selected'; ?> value="100L" <?php }?>> 100L </option>
                <option <?php if ($previousLevel == '200L'){ echo 'selected'; ?> value="200L" <?php }?>> 200L </option>
                <option <?php if ($previousLevel == '300L'){ echo 'selected'; ?> value="300L" <?php }?>> 300L </option>
                <option <?php if ($previousLevel == '400L'){ echo 'selected'; ?> value="400L" <?php }?>> 400L </option>
            </select> <br>

            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <img src="Images/hide.png" alt="Toggle Password" class="eye-icon" onclick="togglePassword()">
            <div class="password-container">
                <input type="password" id="confirm-password" placeholder="Confirm Password" required>
                <img src="Images/hide.png" alt="Toggle Password" class="eye-icon" onclick="togglePassword()">
                <p id="passwordError" style="color: red; display: none;">Passwords do not match</p>
            </div>         
    </div>
    <button type="submit" name="submit"> Update Account </button>
        
    </form>

    <script>
        let email = document.getElementById("email").value
        let emailError = document.getElementById("emailError")
        let registerForm = document.getElementById('registerForm')
        let password = document.getElementById('password')
        let confirmPassword = document.getElementById('confirm-password')
        let passwordError = document.getElementById("passwordError")

        let requiredDomain = "@student.babcock.edu.ng"

        registerForm.addEventListener('submit', function(event) {
            if (!email.includes(requiredDomain)){
            event.preventDefault();
            emailError.style.display = "block"
            }

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