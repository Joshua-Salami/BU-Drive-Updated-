<?php
    include 'connect.php';

    session_start();

    if(isset($_SESSION['adminId'])) {
        $adminId = $_SESSION['adminId'];
        $getAdminDetails = "SELECT * FROM admins WHERE adminId = $adminId";

        $getAdminDetailsResult = mysqli_query($conn, $getAdminDetails);

        if($getAdminDetailsResult){
            while($row = mysqli_fetch_assoc($getAdminDetailsResult)){
                $adminFullName = htmlspecialchars($row['fullName']);
                $adminEmail = htmlspecialchars($row['email']);
                $role = htmlspecialchars($row['role']);

            }
        }
    }

    if(isset($_SESSION['studentId'])) {
        $studentId = $_SESSION['studentId'];
        $getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";

        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);

        if($getStudentDetailsResult){
            while($row = mysqli_fetch_assoc($getStudentDetailsResult)){
                $studentFullName = htmlspecialchars($row['fullName']);
                $studentEmail = htmlspecialchars($row['email']);
                $course = htmlspecialchars($row['course']);
                $level = htmlspecialchars($row['level']);
                $role = htmlspecialchars($row['role']);
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
        <div class="logo"> BU-Drive 🚗 </div>
        <div class="notifications"> 🔔 </div>
    </header>

    <div class="container">
        <?php
            if ($role == 'Admin') echo '<div>
                                            <h2> Admin Details </h2>
                                            <div>
                                                <p>Name: '.$adminFullName.'</p>
                                                <p>email: '.$adminEmail.'</p>
                                            </div>
                                        </div>
                                        <a href="CreateResource.php"><button style="padding: 10px; border-radius: 10px; width: 25%; background-color: #007bff;">Create Resource</button></a>
                                        <a href="UpdateAdminAccount.php?updateId=' . $adminId . '"><button style="padding: 10px; border-radius: 10px; width: 25%; background-color: #007bff;">Update Account</button></a>';
            
            if ($role == 'Student') echo '<div>
                                            <h2> Student Details </h2>
                                            <div>
                                                <p>Name: '.$studentFullName.'</p>
                                                <p>email: '.$studentEmail.'</p>
                                                <p>level: '.$level.'</p>
                                                <p>course: '.$course.'</p>
                                            </div>
                                        </div>
                                        <a href="UpdateStudentAccount.php?updateId=' . $studentId . '"><button style="padding: 10px; border-radius: 10px; width: 25%; background-color: #007bff;">Update Account</button></a>
                                        <a href="CreatePost.php"><button style="padding: 10px; border-radius: 10px; width: 25%; background-color: #007bff;">Create Post</button></a>';
        
        ?>

        <?php if ($role == 'Admin'){?>
            <h4>Resources Uploaded</h4>
            <div class="courses-container">
            </div>
            <h3 id="empty" style="display: none">You have not uploaded any resources.</h3>
        <?php }?>

        <?php 
            if($role == 'Student'){
        ?>
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
                                            </div>
                                        </div>
                                    </div>
                                    <a href="ReadPost.php?postId=' . $postId . '"><button class="btn">Read More</button></a>
                                    <a href="EditPost.php?postId=' . $postId . '"><button class="btn">Edit Post</button></a>
                                    <a href="DeletePost.php?postId=' . $postId . '"><button class="btn" style="background-color: red;">Delete Post</button></a>';
                        }
                    }else {
                        echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>No Posts available.</p>";
                    }
                ?>
            </section>
        <?php }?>

        <a href="Logout.php"><button style="width: 100%; background-color: green; margin-bottom: 40px;">Logout</button></a>

    </div>
    <nav class="navigation">
        <a href="homepage.html" class="nav-item">
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
<?php if($role == "Admin"){?>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
        import { getDatabase, ref, set, push } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-database.js";
        import { getStorage, ref as storageRef, uploadBytes, getDownloadURL } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-storage.js";

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
        const db = getDatabase(app);
        const storage = getStorage(app);

        function RetrieveData() {
            const dbRef = ref(db);
            let coursesContainer = document.querySelector(".courses-container");
            coursesContainer.innerHTML = "";

            get(child(dbRef, "Resource")).then((snapshot) => {
                if (snapshot.exists()) {
                    snapshot.forEach((childSnapshot) => {
                        let resource = childSnapshot.val();
                        let resourceKey = childSnapshot.key;

                        if (resource.adminId == "<?php echo htmlspecialchars($adminId); ?>") {
                            let courseDiv = document.createElement("div");
                            courseDiv.classList.add("courses");

                            let fileUrl = resource.document || resource.audio || resource.video;
                            let fileType = resource.document ? "document" : resource.audio ? "audio" : "video";

                            if (fileUrl) {
                                courseDiv.innerHTML = `
                                    <div><h3>${resource.course}</h3></div>
                                    <a href="${fileUrl}" download>Download Materials</a>
                                    <button class="deleteMaterial" data-key="${resourceKey}" data-url="${fileUrl}" style="background-color: red;">Delete Material</button>
                                `;

                                coursesContainer.appendChild(courseDiv);
                            }
                        }
                    });

                    document.querySelectorAll(".deleteMaterial").forEach(button => {
                        button.addEventListener("click", function () {
                            let resourceKey = this.getAttribute("data-key");
                            let fileUrl = this.getAttribute("data-url");

                            deleteResource(resourceKey, fileUrl);
                        });
                    });

                } else {
                    document.getElementById("empty").style.display = "block";
                }
            }).catch((error) => {
                console.log("Error fetching data:", error);
            });
        }

        function deleteResource(resourceKey, fileUrl) {
            let storageReference = storageRef(storage, fileUrl);

            deleteObject(storageReference).then(() => {
                remove(ref(db, "Resource/" + resourceKey)).then(() => {
                    alert("Resource deleted successfully.");
                    RetrieveData();
                }).catch((error) => {
                    console.log("Error deleting database entry:", error);
                });
            }).catch((error) => {
                console.log("Error deleting file:", error);
            });
        }

        RetrieveData();

    </script>
<?php }?>
    <script src="JS/function.js"> </script>

</body>
</html>