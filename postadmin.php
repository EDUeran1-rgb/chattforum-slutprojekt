<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php
if(!isLevel(1000) and !(isset($_GET['thelink']))){ 
    header("Location: index.php");
}
if(isset($_GET['del'])){
    $id=intval($_GET['del']);
    $sql="SELECT parentid FROM tbl_posts WHERE id=$id";
    $result=mysqli_query($conn, $sql);
    $parid=mysqli_fetch_assoc($result)['parentid'];
    $sql="DELETE FROM tbl_posts WHERE id=$id OR parentid=$id";
    $result=mysqli_query($conn, $sql);
    $sql="DELETE FROM tbl_reviews WHERE revid=$id";
    $result=mysqli_query($conn, $sql);
    
    if (isset($_GET['thelink'])) {
        header("Location: " . urldecode($_GET['thelink']). ($parid != 0 ? "?thepost=" . urlencode($parid) : ""));
    } else {
        header("Location: postadmin.php");
    }
}

if(isset($_POST['btn_edit'])){
    $id=intval($_POST['id']);
    $topic=htmlentities($_POST['topic']);
    $text=htmlentities($_POST['text']);

    $sql="UPDATE `tbl_posts` SET `id`=$id,`topic`='$topic',`text`='$text' WHERE id=$id";
    $result=mysqli_query($conn, $sql);
    $sql="SELECT * FROM tbl_posts WHERE id=$id";
    $result=mysqli_query($conn, $sql);
    $parid=mysqli_fetch_assoc($result)['parentid'];
    if (isset($_POST['thelink'])) {
        if ($parid == 0) {
            header("Location: " . urldecode($_POST['thelink']). "?thepost=" . urlencode($id));
        } else {
            header("Location: " . urldecode($_POST['thelink']). "?thepost=" . urlencode($parid));
        }
    } else {
        header("Location: postadmin.php");
    }
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
        <h1>Post admin</h1>
    </header>
    <?php require_once("_nav.php"); ?>
    <main>
        <?php  if(isset($_GET['edit'])): ?>
            <?php
                $id=intval($_GET['edit']);
                $link=isset($_GET['thelink']) ? urldecode($_GET['thelink']) : 'postadmin.php';
                $sql="SELECT * FROM tbl_posts WHERE id=$id";
                $result=mysqli_query($conn, $sql);
                $row=mysqli_fetch_assoc($result);
                $parid=$row['parentid'];
                

            ?>
        <form action="postadmin.php" method="POST">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="thelink" value="<?=$link?>">
            <div class="user_data"> Post id: <?=$id?>
            <?php if($parid==0){?>   
            <br> Topic: <?=$row['topic']?>
            <?php } ?>
            <br> Text: <?=$row['text']?><br> Rated: <?= $row['rating']?></div>
            <?php if($parid==0){?>   
            <label for="topic">Topic:</label>
            <input type="text" name="topic" id="topic" value="<?=$row['topic']?>">
            <?php } ?>
            
            <label for="text">Text:</label>
            <input type="text" name="text" id="text" value="<?=$row['text']?>">
            <input type="submit" name="btn_edit" value="Update Post" class="registrbttn">
        </form>
        <?php else: ?>
 <?php
    $sql="SELECT * FROM tbl_posts ORDER BY rating DESC"; 
    $result=mysqli_query($conn, $sql);
?>
<?php while($row=mysqli_fetch_assoc($result)): ?>
<details>
    <summary>
        <div>
            <?php if($row['parentid']==0){
                ?><h2 class="headtopic"><?=$row['topic']?>&nbsp;&nbsp;<span></span></h2><?php
            }?>
            <h4 class="expandingboxspace"><?=$row['text']?></h4></div> 
            <div class="filler"></div>
            <?php if (showRating($row['id']) !== false) {
                $rating2 = "Rated:" . showRating($row['id']);
            }else {
                $rating2 = "Not rated yet";
             } ?>  
            <div> <?=$rating2?> &nbsp;&nbsp;<a href="postadmin.php?edit=<?=$row['id']?>">🖋️</a>&nbsp;&nbsp;<a href="postadmin.php?del=<?=$row['id']?>">❌</a></div>   
    </summary>
</details>
<?php endwhile; ?>
            <?php endif; ?>
    </main>
    <?php require_once("_footer.php"); ?>
</body>
</html>