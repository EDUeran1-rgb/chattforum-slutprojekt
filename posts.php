<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php if(isset($_POST['thepost']) or isset($_GET['thepost'])){
    $thepost=intval(urldecode(isset($_POST['thepost']) ? $_POST['thepost'] : $_GET['thepost']));
}?>
<?php if(isset($_POST['userrating'])){
rate(intval($_POST['userrating']), intval($_POST['revid']), intval($_POST['revtype']));
    if (isset($thepost)) {
        header("Location: posts.php?thepost=" . urlencode($thepost));
    } else {
        header("Location: posts.php");
}
}

if(isset($_POST['btnparent'])){
    comment(intval($_POST['parentid']), htmlentities($_POST['text']), 'none');
    if (isset($thepost)) {
        header("Location: posts.php?thepost=" . urlencode($thepost));
    } else {
        header("Location: posts.php");
}
}?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Posts</h1>
    </header>
<?php require_once("_nav.php"); ?>
    <main>


<div class="headpost">
<?php
    if (isset($thepost)) {
        $sql="SELECT * FROM tbl_posts WHERE id=$thepost";
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        if($row){
            $parid=$row['parentid'];
            $topic = $row['topic'];
            $text=$row['text'];
            $theuid=$row['userid'];
        } else {
            echo "<p>Post not found.</p>";
            exit;
        }

        $sql="SELECT * FROM tbl_posts WHERE parentid=$thepost ORDER BY created ASC";  
        ?><a href="posts.php" class="addpost">Back</a><?php

        echo"<h2 class='headtopic'>" . $topic . "</h2>";
        echo"<p class='expandingboxspace'>" . $text . "</p>";
        echo"<p>Posted by: " . getUsername2($theuid) . " Posted: " . $row['created'] . "</p>";
        if(showrating($thepost) !== false){
            echo"<p>Rating: " . showRating($thepost) . "</p>";
        } else {
            echo"<p>Not rated yet</p>";
        }
        
        if(islevel(10)): 
            if($_SESSION['id'] == $theuid) { 
                echo "<div><a href='postadmin.php?edit=" . $thepost . "&thelink=" . urlencode("posts.php") . "'>🖋️</a>&nbsp;&nbsp;<a href='postadmin.php?del=" . $thepost . "&thelink=" . urlencode("posts.php") . "'>❌</a></div>";
            }; 
        if(!hasrated($thepost)){
            echo "<p>Rate this:</p>";
            }else{
                echo "<p>You have rated this:" . showpersonalscore($thepost) . ".<br> Update your rating:</p>";
            }?>
            <form class="rate-form" action="posts.php?thepost=<?=urlencode($thepost)?>" method="POST">
                <input type="hidden" name="revid" value="<?=$thepost?>">
                <input type="hidden" name="revtype" value="post">
                <button  name="userrating" value="1" class="rate">1</button>
                <button  name="userrating" value="2" class="rate">2</button>
                <button  name="userrating" value="3" class="rate">3</button>
                <button  name="userrating" value="4" class="rate">4</button>
                <button  name="userrating" value="5" class="rate">5</button>
            </form>
            
            <?php 
            
            endif;
    } else {
         if (isLevel(10)) { ?>
            <a href="add_post.php" class="addpost">Add new post!</a>
        <?php } 
        $sql="SELECT * FROM tbl_posts WHERE parentid='0' ORDER BY rating DESC";
    }
    $result=mysqli_query($conn, $sql);
    while($row=mysqli_fetch_assoc($result)): ?>
    </div>
<details>
    <summary>
        <div>
            <?php if (!isset($thepost)) { ?>
                <h2 class="headtopic"><?=$row['topic']?></h2>
            <?php }else{ ?>
                <p class="expandingboxspace"><?=$row['text']?></p> 
            <?php } ?>
            <p>By: <?=getUsername2($row['userid'])?> Posted: <?=$row['created']?></p>
        </div>
            <div class="filler"></div>
            
            <?php if (showRating($row['id']) !== false) { ?>
                <div class="ratingdiv">Rated: <?=showRating($row['id'])?> </div> 
            <?php }else { ?>
                <div class="ratingdiv">Not rated yet</div>
            <?php } ?>
            <?php if(islevel(10)) { 
                if($_SESSION['id'] == $row['userid']) { 
                echo "<div><a href='postadmin.php?edit=" . $row['id'] . "&thelink=" . urlencode("posts.php") . "'>🖋️</a>&nbsp;&nbsp;<a href='postadmin.php?del=" . $row['id'] . "&thelink=" . urlencode("posts.php") . "'>❌</a></div>";
                };?>
                <div id="ratearea">
                    <?php if(!hasrated($row['id'])){ 
                        echo "<p>Rate this:</p>";
                    }else{ 
                        echo "<p>You have rated this:" . showpersonalscore($row['id']) . ".<br> Update your rating:</p>";
                     } ?>
                    
                    
                        <?php if (isset($thepost)) { ?>
                        <form class="rate-form" action="posts.php?thepost=<?=urlencode($thepost)?>" method="POST">
                        <?php }else{  ?>
                        <form class="rate-form" action="posts.php" method="POST">
                        <?php } ?>
                        <input type="hidden" name="revid" value="<?=$row['id']?>">
                        <input type="hidden" name="revtype" value="post">
                        <button  name="userrating" value="1" class="rate">1</button>
                        <button  name="userrating" value="2" class="rate">2</button>
                        <button  name="userrating" value="3" class="rate">3</button>
                        <button  name="userrating" value="4" class="rate">4</button>
                        <button  name="userrating" value="5" class="rate">5</button>
                    </form>
                </div>
                
            <?php }  ?>
            <?php if (!isset($thepost)) {?>
                    <a href="posts.php?thepost=<?=urlencode($row['id'])?>" class="addpost">Show more</a>
                <?php } ?>
        </div>
     
    
    </summary>
</details>
<?php endwhile;  ?>
<?php if (isset($thepost)) { 
        if(islevel(10)) { ?>
            <div class="addcomment">
                <pre>
                    <form class="addpost" action="posts.php?thepost=<?=urlencode($thepost)?>" method="POST">
                        <input type="hidden" name="parentid" value="<?=$thepost?>">
                        <input type="text" name="text" placeholder="Add a comment" required>
                        <input type="submit" name="btnparent" value="Add Comment">
                    </form>
                </pre> 
            </div>
        <?php } ?>
    <?php } ?>

    </main>
<?php require_once("_footer.php"); ?>
    <dialog id="login" popover>
        <form action="_login.php" method="POST">
            <?php if (isset($thepost)) { ?>
                <input type="hidden" name="thelink" value="posts.php?thepost=<?=urlencode($thepost)?>">
            <?php } else { ?>
                <input type="hidden" name="thelink" value="posts.php">
            <?php } ?>
            <label for="user">Username</label>
            <input type="text" name="user" placeholder="Username" required>
            <label for="pass">Password</label>
            <input type="password" name="pass" placeholder="Password" required>
            <input type="submit" name="btn_login" value="Log in"class="loginbttn">
        </form>
    </dialog>
    
</body>
</html>