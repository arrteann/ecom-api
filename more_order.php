<?php
include 'config.php';
$idorder=$_GET['orderid'];

$loginclass = new rootview();
$loginclass->More_list_order($idorder);
