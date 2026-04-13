<?php require_once("asset.php"); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>About</h1>
    </header>
    <?php require_once("_nav.php"); ?>
    <main>
        
    </main>
<?php require_once("_footer.php"); ?>
<dialog id="login" popover>
        <form action="_login.php" method="POST">
            <input type="hidden" name="thelink" value="about.php">
            <label for="user">Username</label>
            <input type="text" name="user" placeholder="Username" required>
            <label for="pass">Password</label>
            <input type="password" name="pass" placeholder="Password" required>
            <input type="submit" name="btn_login" value="Log in">
        </form>
    </dialog>
</body>
</html>