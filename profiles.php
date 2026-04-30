<?php require_once("asset.php"); ?>
<?php if(!isLevel(10)){ 
    header("Location: index.php");
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
        <h1>Profiles</h1>
    </header>
    <?php require_once("_nav.php"); ?>
    <main>
        <?php
        $sql="SELECT id, username, realname FROM tbl_user ORDER BY created ASC";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){?>
            <details>
                <summary>
                    <h2 class="headtopic"><?=getusername2($row['id'])?></h2>
                    <div class="filler"></div>
                    <a href="profile.php?profid=<?=$row['id'];?>" class="addpost">View profile</a>
                </summary>
            </details>
        <?php }
        ?>
    </main>
<?php require_once("_footer.php"); ?>
</body>
</html>