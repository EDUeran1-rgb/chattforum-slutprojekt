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
                        <a href="index.php">index</a>
                        <a href="index.php">index</a>
                        <a href="index.php">index</a>
                        <a href="index.php">index</a>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
<?php require_once("_footer.php"); ?>
</body>
</html>