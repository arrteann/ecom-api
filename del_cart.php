<?php
include 'config.php';
$id=$_GET['idcart'];

$loginclass = new rootview();
$loginclass->Del_cart($id);