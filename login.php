<?php
include 'config.php';
$mobile=@$_POST['mobile'];
$pass=@$_POST['pass'];

$loginclass = new rootview();
$loginclass->Getlogin($mobile,$pass);