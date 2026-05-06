<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php
if(!isLevel(1000) and !(isset($_GET['from']))){ 
    header("Location: index.php");
}
if(isset($_GET['del'])){
    $id=intval($_GET['del']);
    $sql="DELETE FROM tbl_user WHERE id=$id";
    $result=mysqli_query($conn, $sql);
    $sql="DELETE FROM tbl_posts WHERE userid=$id";
    $result=mysqli_query($conn, $sql);
    $sql="DELETE FROM tbl_reviews WHERE userid=$id";
    $result=mysqli_query($conn, $sql);
    $sql="DELETE FROM tbl_favorites WHERE userid=$id or favid=$id and favtype='profile'";
    $result=mysqli_query($conn, $sql);
    cleanupUnusedImages();
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
    if(isset($_POST['fromprofile'])){
        $id=intval($_POST['id']);
        if($id == $_SESSION['id']){
            $realname=htmlentities($_POST['realname']);
            $mail=htmlentities($_POST['mail']);
            $username=htmlentities($_POST['username']);
            
            
            $imageid = null;
            if(isset($_FILES['profileimage']) && $_FILES['profileimage']['size'] > 0){
                $imageid = uploadImage('profileimage');
                if($imageid === false){
                    $_SESSION['mess'] = "Invalid image format or too large (max 5MB)";
                    header("Location: useradmin.php?edit=" . $id . "&from=profile");
                    exit;
                }
            }
            
            if($imageid){
                $sql="UPDATE tbl_user SET realname='$realname', mail='$mail', username='$username', profileimageid=$imageid WHERE id=$id";
            } elseif(isset($_POST['remove_profileimage'])){
                $sql="UPDATE tbl_user SET realname='$realname', mail='$mail', username='$username', profileimageid=NULL WHERE id=$id";
            } else {
                $sql="UPDATE tbl_user SET realname='$realname', mail='$mail', username='$username' WHERE id=$id";
            }
            $result=mysqli_query($conn, $sql);
            if(isset($_POST['remove_profileimage'])){
                cleanupUnusedImages();
            }
            header("Location: profile.php");
            } else {
            header("Location: index.php");
        }
    } else {
    $id=intval($_POST['id']);
    $username=$_POST['username'];
    $password=$_POST['password'];
    $userlevel=intval($_POST['userlevel']);
    $lastlogin=$_POST['lastlogin'];
    $realname=$_POST['realname'];
    $mail=$_POST['mail'];
    $created=$_POST['created'];
    if(isset($_POST['remove_profileimage'])){
        $sql="UPDATE tbl_user SET id=$id, username='$username', password='$password', userlevel=$userlevel, lastlogin='$lastlogin', realname='$realname', mail='$mail', created='$created', profileimageid=NULL WHERE id=$id";
    } else {
        $sql="UPDATE tbl_user SET id=$id, username='$username', password='$password', userlevel=$userlevel, lastlogin='$lastlogin', realname='$realname', mail='$mail', created='$created' WHERE id=$id";
    }
    $result=mysqli_query($conn, $sql);
    cleanupUnusedImages(); 
    header("Location: useradmin.php");
}}
if (isset($_POST['btn_edit_pass'])){
    $id=intval($_POST['id']);
    if($id == $_SESSION['id']){
    $password=$_POST['password'];
    if($_POST['password'] !== $_POST['password2']){
        header("Location: profile.php");
        exit();
    }else{
        $sql="SELECT password FROM tbl_user WHERE id=$id";
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        if(md5($_POST['oldpassword']) !== $row['password']){
            header("Location: profile.php");
            exit();
        }else{
            $password=md5($password);
            $sql="UPDATE tbl_user SET password='$password' WHERE id=$id";
            $result=mysqli_query($conn, $sql);
            header("Location: profile.php");
        }
    }
    } else {
        header("Location: index.php");
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Admin</title>
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
        <form action="useradmin.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="password" value="<?=$user_data['password']?>">
            <input type="hidden" name="created" value="<?=$user_data['created']?>">
            <div class="user_data"><?=$id?>&nbsp;&nbsp;<?=$user_data['username']?><br><?=$user_data['created']?></div>
            <?php if(isset($_GET['from'])): ?>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?=$user_data['username']?>" required>
            <?php else: ?>
            <input type="hidden" name="username" value="<?=$user_data['username']?>">
            <?php endif; ?>
            <label for="realname">Real name:</label>
            <input type="text" name="realname" id="realname" value="<?=$user_data['realname']?>">
            <label for="mail">Email:</label>
            <input type="email" name="mail" id="mail" value="<?=$user_data['mail']?>">
            <?php if(isset($_GET['from'])): ?>
            <label for="profileimage">Profile Picture:</label>
            <input type="file" name="profileimage" accept="image/*">
            <?php endif; ?>
            <?php if($user_data['profileimageid']): ?>
                <div style="margin-top: 10px; padding: 10px; border: 1px solid #ccc;">
                    <p>Current profile picture:</p>
                    <img src="display_image.php?user=<?=$user_data['id']?>" alt="Profile picture" style="max-width: 150px; border-radius: 10px;">
                    <br><br>
                    <label>
                        <input type="checkbox" name="remove_profileimage"> Remove this picture
                    </label>
                </div>
            <?php endif; ?>
            <?php if(!isset($_GET['from'])): ?>
            <label for="userlevel">User level: (10-300:user, 301-999:power user, 1000-9999:admin, >10000:superuser)</label>
            <input type="number" name="userlevel" id="userlevel" value="<?=$user_data['userlevel']?>">
            <label for="lastlogin">Users last log in:</label>
            <input type="datetime" name="lastlogin" id="lastlogin" value="<?=$user_data['lastlogin']?>">
            <?php else: ?>
            <input type="hidden" name="fromprofile" value="<?=$_GET['from']?>">
            <?php endif; ?>
            <input type="submit" name="btn_edit" value="Update user" class="registrbttn">
        </form>
        <?php if(isset($_GET['from'])){?>
            <form action="useradmin.php" method="POST">
                <input type="hidden" name="id" value="<?=$id?>">
                <label for="oldpassword">Current password:</label>
                <input type="password" name="oldpassword" id="oldpassword" placeholder="Current password" required>
                <label for="password">New password:</label>
                <input type="password" name="password" id="password" placeholder="New password minimum 8 characters" required pattern=".{8,}">
                <label for="password2">Repeat new password:</label>
                <input type="password" name="password2" id="password2" placeholder="Repeat new password minimum 8 characters" required pattern=".{8,}">
                <input type="submit" name="btn_edit_pass" id="btn_edit_pass" value="Change Password" class="registrbttn">
            </form>
        <?php } ?>
        <?php else: ?>
        <?php
            $sql="SELECT * FROM tbl_user ORDER BY userlevel DESC";
            $result=mysqli_query($conn, $sql);
            while($row=mysqli_fetch_assoc($result)): ?>
                <details>
                    <summary>
                        <div class="id"><?=$row['id'];?></div>
                        <?php $profimg_id = getProfileImageId($row['id']); ?>
                    <?php if($profimg_id): ?>
                    <img src="display_image.php?user=<?=$row['id']?>" alt="Profile picture" class="profilepic" style="width: 30px; height: 30px; border-radius: 10px;">
                    <?php endif; ?>
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
<script>
    //validate if username is taken
    const username=document.getElementById("username");
    names=[
        <?php
            $username=$user_data['username'];
            $sql="SELECT username FROM tbl_user WHERE username !=  $username ";
            $result=mysqli_query($conn, $sql);
            while($row=mysqli_fetch_assoc($result)):?>
                    "<?=$row['username']?>",
        <?php endwhile; ?>
    ]
    username.addEventListener("input", function(){
        if(names.includes(username.value)){
            username.setCustomValidity("Username is already taken");
            username.reportValidity();

        }else{
            username.setCustomValidity("");
            username.reportValidity();

        }
    });

    const password=document.getElementById("password");
    const password2=document.getElementById("password2");
    const oldpassword=document.getElementById("oldpassword");
    const currentpassword="<?= $user_data['password'] ?>";
    const btn_edit_pass=document.getElementById("btn_edit_pass");
    password2.addEventListener("input", function(){
        if(password.value !== password2.value){
            password.setCustomValidity("New passwords do not match");
            password.reportValidity();
            password2.setCustomValidity("New passwords do not match");
            password2.reportValidity();
        }else{
            password.setCustomValidity("");
            password.reportValidity();
            password2.setCustomValidity("");
            password2.reportValidity();
        }
    });
    password.addEventListener("input", function(){
        if(password.value !== password2.value){
            
            password2.setCustomValidity("New passwords do not match");
            password2.reportValidity();
            password.setCustomValidity("New passwords do not match");
            password.reportValidity();
        }else{
            
            password2.setCustomValidity("");
            password2.reportValidity();
            password.setCustomValidity("");
            password.reportValidity();
        }
    });
</script>