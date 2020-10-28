<?php

include 'config.php';
header("Content-type: application/json; charset=utf-8");
$classrootview=new rootview();
$classrootview->getPost();



