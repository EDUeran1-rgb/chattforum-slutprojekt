<?php require_once("asset.php"); ?>
<?php
if(!isLevel(10)){ 
    header("Location: index.php");
}
 if(isset($_GET['changetocom'])){
    $iscomment=intval(urldecode($_GET['changetocom']));
}?>
<?php if(isset($_POST['userrating'])){
rate(intval($_POST['userrating']), intval($_POST['revid']), intval($_POST['revtype']));
    if (isset($iscomment)) {
        header("Location: profile.php?changetocom");
    } else {
        header("Location: profile.php");
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
                        $userid=$_SESSION['id'];
                        if(!isset($_GET["changetocom"])){
                            $sql="SELECT * FROM tbl_posts WHERE parentid='0' AND userid='$userid' ORDER BY rating DESC";
                        } else {
                            $sql="SELECT * FROM tbl_posts WHERE parentid !='0' AND userid='$userid' ORDER BY created DESC";
                        }
                        $result=mysqli_query($conn, $sql);
                        while($row=mysqli_fetch_assoc($result)): 
                        if(!isset($_GET["changetocom"])){
                            
                            $thetext=$row['topic'];
                        } else {
            
                            $thetext=truncateText($row['text'],10);
                        
                        }?>
                        <details>
                            <summary>
                                <div>
                                    <h2 class="headtopic"><?=$thetext?></h2>
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
                                        echo "<div><a href='postadmin.php?edit=" . $row['id'] . "&thelink=" . urlencode("profile.php") . "'>🖋️</a>&nbsp;&nbsp;<a href='postadmin.php?del=" . $row['id'] . "&thelink=" . urlencode("profile.php") . "'>❌</a></div>";
                                        };?>
                                        <div id="ratearea">
                                            <?php if(!hasrated($row['id'])){ 
                                                echo "<p>Rate this:</p>";
                                            }else{ 
                                                echo "<p>You have rated this:" . showpersonalscore($row['id']) . ".<br> Update your rating:</p>";
                                            } ?>
                                            
                                            
                                                <?php if (isset($iscomment)) { ?>
                                                <form class="rate-form" action="profile.php?changetocom" method="POST">
                                                <?php }else{  ?>
                                                <form class="rate-form" action="profile.php" method="POST">
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
                                    <?php if (!isset($iscomment)) {?>
                                            <a href="posts.php?thepost=<?=urlencode($row['id'])?>&profile" class="addpost">Show more in Posts</a>
                                        <?php } else { ?>
                                            <a href="posts.php?thepost=<?=urlencode($row['parentid'])?>&profilecom" class="addpost">Show more in Posts</a>
                                        <?php } ?>
                                
                            
                            
                            </summary>
                            <h4 class="expandingboxspace"><?=$row['text']?></h4>
                        </details>
                        <?php endwhile;?>
                </div>
            </div>
        </div>
    </main>
<?php require_once("_footer.php"); ?>
</body>
</html>