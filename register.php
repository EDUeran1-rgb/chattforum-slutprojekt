<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php
if(isLevel(10)){ 
    header("Location: " . (isset($_GET['thelink']) ? urldecode($_GET['thelink']) : 'index.php'));
}
if(isset($_POST['btn_reg'])){
    $username=$_POST['username'];
    $realname=$_POST['realname'];
    $mail=$_POST['mail'];
    $password=md5($_POST['password']);
    $sql="INSERT INTO tbl_user(username, password, realname, mail) VALUES ('$username', '$password', '$realname', '$mail')";
    $result=mysqli_query($conn, $sql);
    $pass=md5($password);
    $sql="SELECT * FROM tbl_user WHERE ((username='$username') AND (password='$password'))";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)===1){
        $row=mysqli_fetch_assoc($result);
        $_SESSION['mess']="thank you for registering a user! you have been logged in automatically.";
        $_SESSION['name']=$row['realname'];
        $_SESSION['level']=$row['userlevel'];
        $_SESSION['id']=$row['id'];
        $date = new DateTime();
        $sql = "UPDATE tbl_user SET lastlogin = '{$date->format('Y-m-d H:i:s')}' WHERE id = {$row['id']}";
        mysqli_query($conn, $sql);
    }else{
        $_SESSION['mess']="thank you for registering a user! unfortunately we couldn't log you in automatically, please log in manually.";
    }
    header("Location: " . (isset($_GET['thelink']) ? urldecode($_GET['thelink']) : 'index.php'));
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
        <h1>Register</h1>
    </header>
    <?php require_once("_nav.php"); ?>
    <main>
    <?php if(isset($_GET['reg'])): ?>
            <h1>Thank you for registering a user!</h1>
            <a href="<?=isset($_GET['thelink']) ? urldecode($_GET['thelink']) : 'index.php' ?>">Go to homepage</a>
    <?php else: ?>    
    <form action="register.php?thelink=<?=$_GET['thelink']?>" method="POST" onsubmit="disableButton">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Preferred username (required)" required >
        <label for="realname">Real Name</label>
        <input type="text" name="realname" id="realname" placeholder="Your real name (not required)" >
        <label for="mail">Email</label>
        <input type="email" name="mail" id="mail" placeholder="Your email adress (not required but recommended)" >
        <label for="password">Password</label>
        <input type="text" name="password" id="password" placeholder="Password (min 8 chars. required)" required  pattern=".{8,}">
        <input type="submit" name="btn_reg" value="Create user" class="registrbttn">
    </form>
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
            $sql="SELECT username FROM tbl_user";
            $result=mysqli_query($conn, $sql);
            while($row=mysqli_fetch_assoc($result)): ?>
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
    function disableButton{
    const postbtn = document.querySelector('.registrbttn');
    postbtn.disabled = true;
    return true;
    }
</script>