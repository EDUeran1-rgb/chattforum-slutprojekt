<?php require_once("asset.php"); ?>
<?php
if(!isLevel(10)){ 
    header("Location: index.php");
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
        <h1>Profile: <?=getUsername()?></h1>
    </header>
    <?php require_once("_nav.php"); ?>
    <main>
        <div class="profilecontainer">
            <div class="profilespot">
                <h2>Profile Information</h2>
                <p>Username: <?=getUsername()?></p>
                <p>Real Name: <?=getRealname() ? getRealname() : "Not provided" ?></p>
                <p>Email: <?=getMail() ? getMail() : "Not provided" ?></p>
                <p>Account created: <?=getCreated()?></p>
                <div class="profiletoolscontainer">
                    <h2>Tools</h2>
                    <div class="profiletools">
                        <a href="useradmin.php?edit=<?=$_SESSION['id']?>&from=profile">Edit Profile</a>
                        <a href="index.php">index (placeholder)</a>
                        <a href="index.php">index (placeholder)</a>
                        <a href="index.php">index (placeholder)</a>
                        <a href="index.php">index (placeholder)</a>
                    </div>
                </div>
            </div>
            <div class="uposts">
                <div class="toptabs">
                    <a href="profile.php" class="firsttabpost">User posts</a>
                    <a href="profile.php?changetocom" class="secondtabcom">User comments</a>
                </div>
                <div class="theposts">
                    <?php 
                        if(!isset($_GET["changetocom"])){
                            $userid=$_SESSION['id'];
                            $sql="SELECT * FROM tbl_posts WHERE parentid='0' AND userid='$userid' ORDER BY rating DESC";
                            $result=mysqli_query($conn, $sql);
                            while($row=mysqli_fetch_assoc($result)): ?>
                            <details>
                                <summary>
                                    <div>
                                        <h2 class="headtopic"><?=$row['topic']?></h2>
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
                                                <a href="posts.php?thepost=<?=urlencode($row['id'])?>" class="addpost">Show more in Posts</a>
                                            <?php } ?>
                                    
                                
                                
                                </summary>
                            </details>
                            <?php endwhile;
                        }?>
                </div>
            </div>
        </div>
    </main>
<?php require_once("_footer.php"); ?>
</body>
</html>