<?php
session_start();

require_once(".htlibs/globals.php");

$coshh = new coshhDB();

if (array_key_exists('action',$_REQUEST)) {
    $action = $_REQUEST['action'];
    switch ($action) {
        case 'approve':
            $coshh->setFormStatus($_POST['uuid'],"Approved",$_POST['approvemode']);
            break;
        case 'reject':
            $coshh->setFormStatus($_POST['uuid'],"Rejected",$_POST['approvemode']);
            break;
        default:
            break;
    }
}
else {
    if (array_key_exists('id',$_GET)) {
        $coshh->showFormApproval($_GET['id'],false,"supervisor");
    }
    elseif (array_key_exists('gid',$_GET)) {
        $coshh->showFormApproval($_GET['gid'],false,"guardian");
    }
    elseif (array_key_exists('aid',$_GET)) {
        $coshh->showFormApproval($_GET['aid'],false,"coshhadmin");
    }
}


?>
