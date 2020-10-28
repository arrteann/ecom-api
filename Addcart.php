<?php
include 'config.php';
$check=$_GET['check'];
$user=@$_GET['user'];
$prouct=@$_GET['product'];
$count=@$_GET['count'];
$loginclass = new rootview();
if($check=="add"){
$loginclass->Set_Addcart($user,$prouct,$count);
}
else if($check="m"){
    $loginclass->Set_manficart($user,$prouct,$count);
}