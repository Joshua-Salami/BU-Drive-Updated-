<?php
    include 'connect.php';

    $postId = $_GET['postId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Based E-Learning Platform for Babcock Students </title>
    <link rel="stylesheet" href="CSS/homepage.css">

</head>
<body>
<header class="header">
        <div class="logo"><a href="../HTML/homepage.html">BU-Drive <img src="../Icons/externaldrive.fill.badge.icloud.png" alt="logo"></a></div>
        <div class="notifications"><a href="#"><img src="../Icons/bell.png" alt="Notifications icon"></a></div>
    </header>

    <div class="container">
        <section style="margin-top: 100px;">
            <?php
                $getPost = "SELECT * FROM posts WHERE postId = $postId";
                $getPostResult = mysqli_query($conn, $getPost);
            
                if ($getPostResult && mysqli_num_rows($getPostResult) > 0) {
                    while ($row = mysqli_fetch_assoc($getPostResult)) {
                        $studentId = htmlspecialchars($row['studentId']);
                        $postTitle = htmlspecialchars($row['postTitle']);
                        $post = htmlspecialchars($row['post']);

                        $creationDate = new DateTime($row['creationDate']);
                        $formattedDate = htmlspecialchars($creationDate->format('Y-m-d'));
                        $formattedDate = htmlspecialchars(date('Y-m-d', strtotime($row['creationDate'])));

                        $getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";
                        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);
                        if ($getStudentDetailsResult && mysqli_num_rows($getStudentDetailsResult) > 0) {
                            $student = mysqli_fetch_assoc($getStudentDetailsResult);
                            $studentFullName = htmlspecialchars($student['fullName']);
                            $studentEmail = htmlspecialchars($student['email']);
                        }
            
                        echo '<h2 class="section-title">' . $postTitle . '</h2>
                                <div>
                                    <p>' . $post . '</p>
                                    <div class="blog-meta">
                                        <p>By '.$studentFullName.' on ' . $formattedDate . '</p>
                                    </div>
                                </div>';
                    }
                }else {
                    echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>Post Unavailable.</p>";
                }
            ?>
        </section>
            
    </div>

    <nav class="navigation">
        <a href="../HTML/homepage.html" class="nav-item">
            <img src="../Icons/house.fill.png" alt="Profile icon">
            <span>Home</span>
        <a href="../HTML/Resources.html" class="nav-item">
            <img src="../Icons/folder.png" alt="Profile icon">
            <span>Resources</span>
        </a>
        <a href="../HTML/MyCourses.html" class="nav-item">
            <img src="../Icons/my courses.png" alt="Profile icon">
            <span>My Courses</span>
        </a>
        <a href="../HTML/Profile.html" class="nav-item">
            <img src="../Icons/profile.png" alt="Profile icon">
            <span>Profile</span>
        </a>
    </nav>
</body>
</html>
    <script src="JS/function.js"> </script>

</body>
</html>