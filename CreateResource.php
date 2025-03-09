<?php
    include 'connect.php';

    session_start();

    if(isset($_SESSION['adminId'])) {
        $adminId = $_SESSION['adminId'];
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
        <h2> Create Resource </h2>
        
        <select id="department" name="department" required>
            <option value="" disabled selected> Select Department</option>
            <option value="CS"> Computer Science (CS)</option>
            <option value="IT"> Information Technology (IT) </option>
            <option value="CT"> Computer Technology (CT) </option>
        </select> <br>
        <input type="text" id="courseName" name="cName" placeholder="Enter name of course" required> <br>
        <input type="number" id="level" name="level" placeholder="Level" required> <br>
        <p id="levelError" style="color: red; display: none;">Level can only be from 100 to 400 level</p>
        <select id="semester" name="semester">
            <option value="" disabled selected> Select Semester</option>
            <option value="1st Semester"> 1st Semester</option>
            <option value="2nd Semester"> 2nd Semester</option>
        </select> <br>
        <p>Input Document</p>
        <input type="file" id="document" accept=".pdf, .doc, .docx, .xls, .xlsx, .txt">
        <p>Input Video</p>
        <input type="file" id="video" accept="video/mp4,video/mkv,video/avi">
        <p>Input Audio</p>
        <input type="file" id="audio" accept="audio/mpeg,audio/wav,audio/ogg">
        <p id="resourceError" style="color: red; display: none;">Input at least one resource</p>
        <button id="create">Create </button> <br>
    </div>

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

        let create = document.getElementById("create");
        let adminId = <?php echo json_encode($adminId); ?>; 

        create.addEventListener("click", async function () {
            let level = document.getElementById("level").value;
            let department = document.getElementById("department").value;
            let courseName = document.getElementById("courseName").value;
            let semester = document.getElementById("semester").value;
            let levelError = document.getElementById("levelError");
            let resourceError = document.getElementById("resourceError");

            let docFile = document.getElementById("document").files[0];
            let vidFile = document.getElementById("video").files[0];
            let audFile = document.getElementById("audio").files[0];

            levelError.style.display = "none";
            resourceError.style.display = "none";

            if (level < 100 || level > 400) {
                levelError.style.display = "block";
                return;
            }

            if (!docFile && !vidFile && !audFile) {
                resourceError.style.display = "block";
                return;
            }

            let resourceId = push(ref(db, "Resource/")).key;

            let data = {
                adminId: Number(adminId),
                department: department,
                courseName: courseName,
                level: Number(level),
                semester: semester,
                document: "",
                video: "",
                audio: ""
            };

            // 🔹 Function to Upload File & Get URL
            async function uploadFile(file, folder) {
                const fileRef = storageRef(storage, `resources/${resourceId}/${file.name}`);
                await uploadBytes(fileRef, file);
                return await getDownloadURL(fileRef);
            }

            // 🔹 Upload files if they exist
            if (docFile) data.document = await uploadFile(docFile, "documents");
            if (vidFile) data.video = await uploadFile(vidFile, "videos");
            if (audFile) data.audio = await uploadFile(audFile, "audios");

            // 🔹 Save Resource Info to Database
            set(ref(db, "Resource/" + resourceId), data)
                .then(() => {
                    window.location.href = "Profile.php";
                })
                .catch((error) => {
                    alert("Upload unsuccessful");
                    console.error(error);
                });
        });

    </script>

    <script src="JS/function.js"></script>
</body>
</html>