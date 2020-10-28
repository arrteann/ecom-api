<?php
include 'config.php';
$user_id=@$_GET['user_id'];

$loginclass = new rootview();
$loginclass->Get_user_info($user_id);