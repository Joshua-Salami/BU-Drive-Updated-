<?php
include 'connect.php';

$postId = $_GET['postId'];

$getPostDetails = "SELECT * FROM posts WHERE postId = $postId";
$getPostDetailsResult = mysqli_query($conn, $getPostDetails);


$row = mysqli_fetch_assoc($getPostDetailsResult);

$previousPostTitle = htmlspecialchars($row['postTitle']);
$previousPost = htmlspecialchars($row['post']);
$previousImage = 'data:image/jpeg;base64,' . base64_encode($row['image']);

if(isset($_POST['submit'])){
    $postTitle=$_POST['postTitle'];
    $post=$_POST['post'];
    $creationDate = date('Y-m-d');
    $image=$_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    $updateQueue = "UPDATE posts SET postTitle = '$postTitle', post = '$post', creationDate = '$creationDate', image = '$imgContent' WHERE postId = $postId";

    $updateQueueResult = mysqli_query($conn, $updateQueue);

    if ($updateQueueResult) {
        header("Location: ./Profile.php");
    }
    else {
        echo "Error updating posts: " . $conn->error;
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
        <h2> Edit Post </h2>
        
        <form id="postForm" method="post">
            <input type="text" id="postTitle" name="pTitle" placeholder="Post Title" value="<?php echo $previousPostTitle; ?>" required> <br>
            <label for="post">Post</label>
            <textarea name="post" id="post" placeholder="Post" rows="15" cols="10" required style="width: 100%; padding: 20px" value="<?php echo $previousPost; ?>"></textarea>
            
            <label for="image">Image</label>
            <div>
                <img src="<?php echo $previousImage; ?>" alt="Previous Image" style="height: 100px; width: 100px; object-fit: cover; margin-bottom: 10px;">
            </div>
            <input type="file" value="Image" name="image" required accept=".jpeg, .png">

            <button type="submit"> Edit </button> <br>
        </form>
    </div>

    <script src="JS/function.js"></script>
</body>
</html>