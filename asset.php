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
function isFavorited($favid, $favtype){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="SELECT * FROM tbl_favorites WHERE userid=$userid AND favid=$favid AND favtype='$favtype'";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        return true;
    }else{
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
function getRealname2($uid){
    global $conn;
    $userid=$uid;
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
function getMail2($uid){
    global $conn;
    $userid=$uid;
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
function getCreated2($uid){
    global $conn;
    $userid=$uid;
    $sql="SELECT created FROM tbl_user WHERE id=$userid";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        
        return $row['created'];
    }else{
        return null;
    }
}

function comment($revid, $text,$type){
    global $conn;
    $userid=$_SESSION['id'];
    $sql="INSERT INTO tbl_posts (userid, text, parentid, type) VALUES ('$userid', '$text', $revid,'$type')";
    mysqli_query($conn, $sql);
}
function truncateText($text, $limit = 100) {
    if (strlen($text) <= $limit) {
        return $text;
    }
    $truncated = substr($text, 0, $limit);
    
    return $truncated . '...';
}

function uploadImage($file_input_name){
    global $conn;
    if(!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['size'] == 0){
        return null;
    }
    
  
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if(!in_array($_FILES[$file_input_name]['type'], $allowed_types)){
        return false;
    }
    
   
    if($_FILES[$file_input_name]['size'] > 5 * 1024 * 1024){
        return false;
    }
    
   
    $imagedata = file_get_contents($_FILES[$file_input_name]['tmp_name']);
    $imagetype = $_FILES[$file_input_name]['type'];
    
  
    $sql = "INSERT INTO tbl_images (imagedata, imagetype) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $imagedata, $imagetype);
    
    if($stmt->execute()){
        return $conn->insert_id; 
    }
    return false;
}


function getImageData($imageid){
    global $conn;
    $sql = "SELECT imagedata, imagetype FROM tbl_images WHERE id=$imageid";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        return mysqli_fetch_assoc($result);
    }
    return null;
}


function getProfileImageId($uid){
    global $conn;
    $sql = "SELECT profileimageid FROM tbl_user WHERE id=$uid";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        return $row['profileimageid'];
    }
    return null;
}


function getPostImageId($postid){
    global $conn;
    if(!$postid) return null;
    $sql = "SELECT postimageid FROM tbl_posts WHERE id=$postid";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        return $row['postimageid'];
    }
    return null;
}
function cleanupUnusedImages(){
    global $conn;
    $sql = "DELETE FROM tbl_images WHERE id NOT IN (
        SELECT profileimageid FROM tbl_user WHERE profileimageid IS NOT NULL
        UNION
        SELECT postimageid FROM tbl_posts WHERE postimageid IS NOT NULL
    )";
    mysqli_query($conn, $sql);
}
?>