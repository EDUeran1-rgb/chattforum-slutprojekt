<?php
require_once("asset.php");

$imageid = null;

if(isset($_GET['user'])){
    $uid = intval($_GET['user']);
    $imageid = getProfileImageId($uid);
} elseif(isset($_GET['post'])){
    $postid = intval($_GET['post']);
    $imageid = getPostImageId($postid);
}

if(!$imageid){
    header("HTTP/1.0 404 Not Found");
    exit("Image not found");
}

$imagedata = getImageData($imageid);

if($imagedata){
    header("Content-Type: " . $imagedata['imagetype']);
    echo $imagedata['imagedata'];
} else {
    exit("Image not found");
}
?>