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
        <h2> Create Post </h2>
        
        <form id="postForm" method="post" action="./Post.php" enctype="multipart/form-data">
            <input type="text" id="postTitle" name="pTitle" placeholder="Post Title" required> <br>
            <label for="post">Post</label>
            <textarea name="post" id="post" placeholder="Post" rows="15" cols="10" required style="width: 100%; padding: 20px"></textarea>
            
            <label for="image">Image</label>
            <input type="file" value="Image" name="image" required accept=".jpeg, .png">

            <button type="submit"> Create </button> <br>
        </form>
    </div>

    <script src="JS/function.js"></script>
</body>
</html>