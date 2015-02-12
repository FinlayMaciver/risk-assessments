<?php
session_start();

require_once(".htlibs/globals.php");

$coshh = new coshhDB();
$coshh->tpl->assign("page_title","Existing forms");

if (array_key_exists('action',$_REQUEST)) {
    $action = $_REQUEST['action'];
}
else {
    $action = "";
}
switch ($action) {
    case 'view':
        $coshh->showFormApproval($_GET['id'],false,"guest");
        break;
    case 'search':
        $coshh->searchForms($_REQUEST['q'],$_REQUEST['f']);
        break;
    case 'listmulti':
        $coshh->showMultiFormList();
        break;
    default:
        $coshh->showFormList();
        break;
}

?>
