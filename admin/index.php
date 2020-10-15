<?php 
include_once '../config/Config.php';
$con = new Config();
if($con->auth()){
    //panggil fungsi
    switch (@$_GET['mod']){
        case 'dokter':
            include_once 'controller/dokter.php';
            break;
        default:
        include_once 'controller/dokter.php';
    }
}else{
    //panggil cont login
    include_once 'controller/login.php';
}
?>