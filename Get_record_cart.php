<?php
include 'config.php';
$id=$_GET['user'];

$loginclass = new rootview();
$loginclass->Record_cart_get($id);