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

    $selectedCourse = isset($_GET['course']) ? htmlspecialchars($_GET['course']) : '';
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
        <div class="logo"> BU-Drive 🚗 </div>
        <div class="notifications"> 🔔 </div>
    </header>

    <div class="container">
        <h2> 2nd Semester, <?php echo ''.$level.''; ?> L</h2>
        <div id="search-container">
            <img src="Images/magnifying-glass.png" alt="Search" class="search-icon">
            <input type="text" id="search" placeholder="Search...">
        </div>
                <div class="courses-container">
                </div>
                <h3 id="empty" style="display: none">No resources found.</h3>

    <nav class="navigation">
        <a href="HTML/homepage.html" class="nav-item">
            🏠
            <span>Home</span>
        <a href="Resources.html" class="nav-item">
            📚
            <span>Resources</span>
        </a>
        <a href="MyCourses.html" class="nav-item">
            🎓
            <span>My Courses</span>
        </a>
        <a href="#" class="nav-item">
            👤
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

        import {getDatabase, ref, child, get, set, update, remove} from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js"

        const db = getDatabase()

        let courseName = document.getElementById("courseName");
        let empty = document.getElementById("empty");

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
                            let courseName = "<?php echo $selectedCourse; ?>";
                            courseDiv.classList.add("courses");
                            if(resource.course == courseName){
                                if(resource.document){
                                    courseDiv.innerHTML = `
                                    <div><h3>${resource.course}</h3></div>
                                    <a href="course=${resource.document}" download>Download Materials</a>
                                    `;
                                }

                                if(resource.audio){
                                    courseDiv.innerHTML = `
                                    <div><h3>${resource.course}</h3></div>
                                    <a href="course=${resource.audio}" download>Download Materials</a>
                                    `;
                                }

                                if(resource.video){
                                    courseDiv.innerHTML = `
                                    <div><h3>${resource.course}</h3></div>
                                    <a href="course=${resource.video}" download>Download Materials</a>
                                    `;
                                }
                        
                                coursesContainer.appendChild(courseDiv);
                            }
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