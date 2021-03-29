<?php
session_start();

require_once(".htlibs/globals.php");

$coshh = new coshhDB();
$coshh->tpl->assign("admin",true);

if (!array_key_exists('id',$_GET)) {
    exit();
}

$coshh->sendFile($_GET['id']);

?>
