<?php
session_start();

require_once(".htlibs/globals.php");

$coshh = new coshhDB();
$coshh->tpl->assign("admin",true);
$coshh->tpl->assign("page_title","Administration");

if (array_key_exists('action',$_REQUEST)) {
    $action = $_REQUEST['action'];
}
else {
    $action = "";
}

switch ($action) {
    case 'approve':
        $coshh->approveForm($_POST['uuid']);
        break;
    case 'reject':
        $coshh->rejectForm($_POST['uuid']);
        break;
    case 'view':
        $coshh->showFormApproval($_GET['id'],false,"coshhadmin");
        break;
    case 'search':
        $coshh->searchForms($_REQUEST['q'],$_REQUEST['f']);
        break;
    case 'remove':
        $coshh->removeItem($_REQUEST['id']);
        $coshh->showFormList();
        break;
    case 'listmulti':
        $coshh->showMultiFormList();
        break;
    case 'getformlist':
        $coshh->exportAllAsPdf();
        break;
    default:
        $coshh->showFormList();
        break;
}

?>
