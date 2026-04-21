    <nav>
        <?php require_once("asset.php"); ?>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="posts.php">Posts</a>
        
        <div class="fill"></div>
        <?php if(isLevel(1000)):?>
            <a href="postadmin.php">Post Admin</a>
            <?php if(isLevel(10000)){?>
            <a href="useradmin.php">User Admin</a>
        <?php }endif; ?>
        <?php if(!isLevel(10)){?>
        <a href="register.php?thelink=<?=urlencode($_SERVER['REQUEST_URI'])?>">Register</a>
        <button class="loginbttn" popovertarget="login">Login</button>
        <?php }else{ ?>
        <a href="_login.php?logout=1&thelink=<?=urlencode($_SERVER['REQUEST_URI'])?>">Logout</a>
        <a href="profile.php">Profile</a>
        <div class="userinfo">
            <h2>logged in as: <?=getUsername()?></h2>
        <?php } ?>
    </nav>