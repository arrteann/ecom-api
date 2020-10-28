<?php
include 'config.php';
$iduser=$_GET['user'];
$idaddress=$_GET['address'];

$loginclass = new rootview();
$loginclass->Add_order($iduser,$idaddress);
