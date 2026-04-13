<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php if(isset($_POST['userrating'])):rate(intval($_POST['userrating']), intval($_POST['revid']), intval($_POST['revtype']));
header("Location: index.php"); 
endif;
if(isset($_POST['btnparent'])){
    comment(intval($_POST['parentid']), htmlentities($_POST['text']), 'none');
    header("Location: index.php");
}
?>

<?php
$mess="";
if(isset($_SESSION['mess'])){
    $mess=$_SESSION['mess'];
}else{
    $mess="";
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
        <h1>Main Page</h1>
    </header>
<?php require_once("_nav.php"); ?>
    <main>
<h1 class="message"><?=$mess;?></h1>



    </main>
<?php require_once("_footer.php"); ?>
    <dialog id="login" popover>
        <form action="_login.php" method="POST">
            <input type="hidden" name="thelink" value="index.php">
            <label for="user">Username</label>
            <input type="text" name="user" placeholder="Username" required>
            <label for="pass">Password</label>
            <input type="password" name="pass" placeholder="Password" required>
            <input type="submit" name="btn_login" value="Log in">
        </form>
    </dialog>
    
</body>
</html>