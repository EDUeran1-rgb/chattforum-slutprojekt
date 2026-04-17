<?php
session_start();
$db_host="localhost";
$db_user="root";
$db_pass="";
$db_name="chatforum";
$conn=mysqli_connect($db_host, $db_user, $db_pass, $db_name);

function hasrated($revid){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="SELECT * FROM tbl_reviews WHERE userid=$userid AND revid=$revid";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}



function rate($userrating, $revid, $revtype){
    $userid=$_SESSION['id'];
    global $conn;
    if (!hasrated($revid)) {
        $sql="INSERT INTO tbl_reviews (userid, score, revid, revtype) VALUES ($userid, $userrating, $revid, $revtype)";
        
    } else {
        $sql="UPDATE tbl_reviews SET score=$userrating WHERE userid=$userid AND revid=$revid AND revtype=$revtype"; 
        
    }
    mysqli_query($conn, $sql);
    $date = new DateTime();
    $sql = "UPDATE tbl_reviews SET rated = '{$date->format('Y-m-d H:i:s')}' WHERE id = $userid AND revid=$revid AND revtype=$revtype";
    mysqli_query($conn, $sql);
    
}

function isLevel($level){
    if(isset($_SESSION['level'])){
        if(intval($_SESSION['level'])>=$level){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function fix($str_raw){
    $str_raw=trim($str_raw);
    $str_raw=stripslashes($str_raw);
    $str_raw=htmlspecialchars($str_raw); 
    return $str_raw;
}

function isUserTaken($username){
    global $conn;
    $sql="SELECT username FROM tbl_user WHERE username='$username'";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}
function showpersonalscore($revid){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="SELECT score FROM tbl_reviews WHERE userid=$userid AND revid=$revid";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        $retStr="";
        for($vdo=0;$vdo<$row['score'];$vdo++){
            $retStr.="⭐";
        }
        return $retStr;
    }else{
        return "Not rated yet";
    }
}

function showRating($revid){
    global $conn;
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_reviews WHERE revid='$revid' LIMIT 1")) > 0) {
        $sql="SELECT AVG(score) as rating FROM tbl_reviews WHERE revid='$revid'";
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        $rating=$row['rating'];
        $sql="UPDATE tbl_posts SET rating=$rating WHERE id=$revid";
        mysqli_query($conn, $sql);
        $number=intval(round($row['rating']));
        $retStr="";
        for($vdo=0;$vdo<$number;$vdo++){
            $retStr.="⭐";
        }
        return $retStr;
    } else {
        return false;
    }
}

function getUsername(){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="SELECT username FROM tbl_user WHERE id=$userid";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        
        return $row['username'];
    }else{
        return "Guest";
    }
}
function getUsername2($uid){
    global $conn;
    $sql="SELECT username FROM tbl_user WHERE id=$uid";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        
        return $row['username'];
    }else{
        return "Guest";
    }
}

function getRealname(){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="SELECT realname FROM tbl_user WHERE id=$userid";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        
        return $row['realname'];
    }else{
        return null;
    }
}

function getMail(){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="SELECT mail FROM tbl_user WHERE id=$userid";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        
        return $row['mail'];
    }else{
        return null;
    }
}

function getCreated(){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="SELECT created FROM tbl_user WHERE id=$userid";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        
        return $row['created'];
    }else{
        return null;
    }
}

function comment($revid, $text,$parnttype){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="INSERT INTO tbl_posts (userid, text, parentid, parenttype) VALUES ('$userid', '$text', $revid,'$parnttype')";
    mysqli_query($conn, $sql);
}
?>