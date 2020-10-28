<?php
include 'config.php';
$iduser=$_GET['user'];

$loginclass = new rootview();
$loginclass->List_order($iduser);
