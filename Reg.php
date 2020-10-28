<?php
include 'config.php';
$name=@$_POST['name'];
$mobile=@$_POST['mobile'];
$email=@$_POST['email'];
$pass=@$_POST['pass'];

$r_register=new rootview();
if(isset($_POST['name']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['pass'] ))
{
    $r_register->GetRegister($name,$mobile,$email,$pass);
}
