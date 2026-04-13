<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php
if(!isLevel(1000)){ 
    header("Location: index.php");
}
if(isset($_GET['del'])){
    $id=intval($_GET['del']);
    $sql="DELETE FROM tbl_user WHERE id=$id";
    $result=mysqli_query($conn, $sql);
    header("Location: useradmin.php");
}
if(isset($_GET['level'])){
    $id=intval($_GET['level']);
    $sql="SELECT userlevel FROM tbl_user WHERE id=$id";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $initlevel=$row['userlevel'];
    $newlevel=$initlevel-100;
    $sql="UPDATE tbl_user SET userlevel=$newlevel WHERE id=$id";
    $result=mysqli_query($conn,$sql);
    header("Location: useradmin.php");
}
if(isset($_POST['btn_edit'])){
    $id=intval($_POST['id']);
    $username=$_POST['username'];
    $password=$_POST['password'];
    $userlevel=intval($_POST['userlevel']);
    $lastlogin=$_POST['lastlogin'];
    $realname=$_POST['realname'];
    $mail=$_POST['mail'];
    $created=$_POST['created'];
    $sql="UPDATE tbl_user SET id=$id, username='$username', password='$password', userlevel=$userlevel, lastlogin='$lastlogin', realname='$realname', mail='$mail', created='$created' WHERE id=$id";
    $result=mysqli_query($conn, $sql);
    header("Location: useradmin.php");
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
        <h1>User admin</h1>
    </header>
    <?php require_once("_nav.php"); ?>
    <main>
        <?php  if(isset($_GET['edit'])): ?>
            <?php
                $id=intval($_GET['edit']);
                $sql="SELECT * FROM tbl_user WHERE id=$id";
                $result=mysqli_query($conn, $sql);
                $user_data=mysqli_fetch_assoc($result);

            ?>
        <form action="useradmin.php" method="POST">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="username" value="<?=$user_data['username']?>">
            <input type="hidden" name="password" value="<?=$user_data['password']?>">
            <input type="hidden" name="created" value="<?=$user_data['created']?>">
            <div class="user_data"><?=$id?>&nbsp;&nbsp;<?=$user_data['username']?><br><?=$user_data['password']?><br><?=$user_data['created']?></div>
            <label for="realname">Real name:</label>
            <input type="text" name="realname" id="realname" value="<?=$user_data['realname']?>">
            <label for="mail">Email:</label>
            <input type="email" name="mail" id="mail" value="<?=$user_data['mail']?>">
            <label for="userlevel">User level: (10-300:user, 301-999:power user, 1000-9999:admin, >10000:superuser)</label>
            <input type="number" name="userlevel" id="userlevel" value="<?=$user_data['userlevel']?>">
            <label for="lastlogin">Users last log in:</label>
            <input type="datetime" name="lastlogin" id="lastlogin" value="<?=$user_data['lastlogin']?>">
            <input type="submit" name="btn_edit" value="Update user">
        </form>
        <?php else: ?>
        <?php
            $sql="SELECT * FROM tbl_user ORDER BY userlevel DESC";
            $result=mysqli_query($conn, $sql);
            while($row=mysqli_fetch_assoc($result)): ?>
                <details>
                    <summary>
                        <div class="id"><?=$row['id'];?></div>
                        <div class="user"><?=$row['username'];?></div>
                        <div class="level"><?=$row['userlevel'];?></div>
                    </summary>
                    <div class="realname"><?=$row['realname'];?></div>
                    <div class="mail"><a href="mailto:<?=$row['mail'];?>"><?=$row['mail'];?></a></div>
                    <div class="userdetails">
                        <div class="id">ID: <?=$row['id'];?> </div>
                        <div class="user"> Username: <?=$row['username'];?> </div>
                        <div class="level">&nbsp;&nbsp;Level: <?=$row['userlevel'];?> </div>
                    </div>
                    <div class="last">Last login: <?=$row['lastlogin']; ?></div>
                    <div class="created">User created: <?=$row['created']; ?></div>
                    <div class="buttons">
                        <a href="useradmin.php?level=<?=$row['id'];?>">Demote</a>
                        <a href="useradmin.php?edit=<?=$row['id'];?>">Edit</a>
                        <a href="useradmin.php?del=<?=$row['id'];?>">Purge</a>
                    </div>
                </details>
            <?php endwhile; ?>
            <?php endif; ?>
    </main>
    <?php require_once("_footer.php"); ?>
</body>
</html>