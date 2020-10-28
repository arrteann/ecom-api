<?php
include 'config.php';
$id=$_GET['user'];
$loginclass = new rootview();
$loginclass->Get_Cartpricenumber($id);