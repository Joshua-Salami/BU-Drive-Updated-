<?php
    include 'connect.php';
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
        <div class="logo"> BU-Drive 🚗 </div>
        <div class="notifications"> 🔔 </div>
    </header>

    <div class="container">
       <div id="search-container">
            <img src="Images/magnifying-glass.png" alt="Search" class="search-icon" onclick="expandSearch()">
            <input type="text" id="search" placeholder="Explore..." onclick="expandSearch()">
    </div>

        <section>
            <h2 class="section-title">Weekly Poll</h2>
            <div class="weekly-polls">
                <div class="poll-card">
                    <div class="poll-header">
                        <div class="poll-icon">📊</div>
                        <div>
                            <h3>What's your favorite way to study?</h3>
                            <p class="poll-stats">2d left</p>
                        </div>
                    </div>
                    <button class="btn">View Poll</button>
                </div>
                <div class="poll-card">
                    <div class="poll-header">
                        <div class="poll-icon">📊</div>
                        <div>
                            <h3>What's your favorite course this semester?</h3>
                            <p class="poll-stats">2d left</p>
                        </div>
                    </div>
                    <button class="btn">View Poll</button>
                </div>
            </div>
        </section>

        <section>
            <h2 class="section-title">Resource Highlight of the Week</h2>
            <div class="resources">
                <div class="resource-card">
                    <img src = "Images/joao-ferrao-4YzrcDNcRVg-unsplash.jpg" alt="Resume writing" class="resource-image">
                    <div class="resource-content">
                        <h3>How to write a resume that stands out</h3>
                        <p>3 articles</p>
                        <button class="btn">Read More</button>
                    </div>
                </div>
                <div class="resource-card">
                    <img src="Images/carlos-muza-hpjSkU2UYSU-unsplash.jpg" alt="Excel formulas" class="resource-image">
                    <div class="resource-content">
                        <h3>Learn how to use Excel formulas</h3>
                        <p>2 videos</p>
                        <button class="btn">Watch now</button>
                    </div>
                </div>
            </div>
        </section>

        <h2 class="section-title">Blog</h2>
        <section>
            <?php
                $getPosts = "SELECT * FROM posts ORDER BY creationDate DESC";
                $getPostsResult = mysqli_query($conn, $getPosts);
            
                if ($getPostsResult && mysqli_num_rows($getPostsResult) > 0) {
                    while ($row = mysqli_fetch_assoc($getPostsResult)) {
                        $studentId = $row['studentId'];
                        $postId = $row['postId'];
                        $postTitle = htmlspecialchars($row['postTitle']);
                        $post = htmlspecialchars($row['post']);
            
                        $creationDate = new DateTime($row['creationDate']);
                        $formattedDate = htmlspecialchars($creationDate->format('Y-m-d'));
                        $formattedDate = htmlspecialchars(date('Y-m-d', strtotime($row['creationDate'])));
                        $image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
            
                        $getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";
                        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);
                        if ($getStudentDetailsResult && mysqli_num_rows($getStudentDetailsResult) > 0) {
                            $student = mysqli_fetch_assoc($getStudentDetailsResult);
                            $studentFullName = htmlspecialchars($student['fullName']);
                            $studentEmail = htmlspecialchars($student['email']);
                        }

                        echo '
                                <div class="blog-posts">
                                    <div class="blog-card">
                                        <img src="'.$image.'" alt="Remote learning" class="blog-image">
                                        <div class="blog-content">
                                            <h3>' . $postTitle . '</h3>
                                            <div class="blog-meta">
                                                <p>By '.$studentFullName.' on ' . $formattedDate . '</p>
                                            </div>
                                             <a href="ReadPost.php?postId=' . $postId . '"><button class="btn">Read More</button></a></br>
                                        </div>
                                    </div>
                                </div>';
                    }
                }else {
                    echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>No Posts available.</p>";
                }
            ?>
        </section>
            
    </div>

    <nav class="navigation">
        <a href="Homepage.php" class="nav-item">
            🏠
            <span>Home</span>
        <a href="Resources.html" class="nav-item">
            📚
            <span>Resources</span>
        </a>
        <a href="SelectSem.html" class="nav-item">
            🎓
            <span>My Courses</span>
        </a>
        <a href="Profile.php" class="nav-item">
            👤
            <span>Profile</span>
        </a>
    </nav>
</body>
</html>
    <script src="JS/function.js"> </script>

</body>
</html>