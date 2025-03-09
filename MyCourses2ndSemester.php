<?php
    include 'connect.php';

    session_start();

    if(isset($_SESSION['studentId'])) {
        $studentId = $_SESSION['studentId'];
        $getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";

        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);

        if($getStudentDetailsResult){
            while($row = mysqli_fetch_assoc($getStudentDetailsResult)){
                $level = htmlspecialchars($row['level']);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Based E-Learning Platform for Babcock Students </title>
    <link rel="stylesheet" href="CSS/MyCourses.css">

</head>
<body>
<header class="header">
        <div class="logo"><a href="../HTML/homepage.html">BU-Drive <img src="../Icons/externaldrive.fill.badge.icloud.png" alt="logo"></a></div>
        <div class="notifications"><a href="#"><img src="../Icons/bell.png" alt="Notifications icon"></a></div>
    </header>

    <div class="container">
        <h2> 2nd Semester, <?php echo ''.$level.''; ?> L</h2>
        <div id="search-container">
            <img src="Images/magnifying-glass.png" alt="Search" class="search-icon">
            <input type="text" id="search" placeholder="Search...">
        </div>
                <div class="courses-container">
                <div class="courses">
                </div>
                </div>
                <h3 id="empty" style="display: none">No resources found.</h3>

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
<script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";

        const firebaseConfig = {
          apiKey: "AIzaSyABHAfb8DGfwhTPY__jsgrsv7VRqv0Ei6M",
          authDomain: "bu-drive-236c1.firebaseapp.com",
          databaseURL: "https://bu-drive-236c1-default-rtdb.firebaseio.com",
          projectId: "bu-drive-236c1",
          storageBucket: "bu-drive-236c1.appspot.com",
          messagingSenderId: "998018097892",
          appId: "1:998018097892:web:a015ddc4dd4391d73842f1"
        };
      
        const app = initializeApp(firebaseConfig);

        import {getDatabase, ref, child, get, set, update, remove} from "https://www.gstatic.com/firebasejs/11.4.0/firebase-database.js"

        const db = getDatabase()

        let courseName = document.getElementById("courseName");
        let empty = document.getElementById("empty")

        function RetrieveData() {
            const dbRef = ref(db);

            get(child(dbRef, "Resource")).then((snapshot) => {
                if (snapshot.exists()) {
                    let coursesContainer = document.querySelector(".courses-container");
            
                    coursesContainer.innerHTML = "";

                    snapshot.forEach((childSnapshot) => {
                        let resource = childSnapshot.val();

                        if (resource.level == <?php echo $level; ?> && resource.semester == "2nd Semester") {
                            let courseDiv = document.createElement("div");
                            courseDiv.classList.add("courses");

                            courseDiv.innerHTML = `
                                <div><h3>${resource.course}</h3></div>
                                <a href="1stSemesterResource.php?course=${encodeURIComponent(resource.course)}">View Materials</a>
                            `;

                            coursesContainer.appendChild(courseDiv);
                        }
                    });
                } else {
                    empty.style.display = "block"
                }
            }).catch((error) => {
                console.log("Error fetching data:", error);
            });
        }

        RetrieveData();

    </script>
    <script src="JS/function.js"> </script>
</body>
</html>