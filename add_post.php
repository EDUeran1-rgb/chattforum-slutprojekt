<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php
if(!isLevel(10)){ 
    header("Location: index.php");
}
if(isset($_POST['btnparent'])){
        $parentid=intval($_POST['parentid']);
    } else {
        $parentid=0;
    }
if(isset($_POST['btnAdd'])){
    $text=htmlentities($_POST['text']);
    $userid=$_SESSION['id'];
    $parentid=htmlentities($_POST['parentid']);
    $topic=htmlentities($_POST['topic']);
    $sql="INSERT INTO tbl_posts (userid, text, parentid, parenttype, topic ) VALUES ('$userid', '$text', $parentid,'none', '$topic')";
    $result=mysqli_query($conn, $sql);
    header("Location: posts.php");
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Add post</h1>
    </header>
<?php require_once("_nav.php"); ?>
    <main>
        <form action="add_post.php" method="POST" class="addpostform">
            <input type="text" name="topic" placeholder="Topic" required>
            <textarea name="text" placeholder="Text" required class="addposttext"></textarea>
            <input type="hidden" name="parentid" value="<?=$parentid?>">
            <input type="submit" name="btnAdd" value="Add" class="addpostbttn">
        </form>
    </main>
<?php require_once("_footer.php"); ?>
</body>
</html>