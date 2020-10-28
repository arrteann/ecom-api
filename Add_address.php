<?php
include 'config.php';
$iduser=$_GET['iduser'];
$city=$_GET['city'];
$meli=$_GET['meli'];
$code=$_GET['code'];
$address=$_GET['address'];
$phone=$_GET['phone'];
$tell=$_GET['tell'];
$loginclass = new rootview();
$loginclass->Set_Add_Address($iduser,$city,$meli,$code,$address,$phone,$tell);