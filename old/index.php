<?php
session_start();

require_once(".htlibs/globals.php");
//require_once("js/vf/libraries/ValidForm/class.validform.php");

$coshh = new coshhDB();

if (array_key_exists('action',$_REQUEST)) {
    $action = $_REQUEST['action'];
}
else {
    $action = "";
}

// short-curcuit if we are re-sending email alerts
if ($action == 'resendalert') {
    $coshh->resendAlerts($_GET['id']);
    exit;
}

// if we have a $_GET['id'] then we are in edit/re-submit mode, so ignore the $action
if (array_key_exists('id',$_GET)) {
    $coshh->editForm($_GET['id']);
}
else {
    switch ($action) {
        case 'submit_coshh':
            $coshh->submitForm();
            break;
        case 'submit_jwnc':
            $coshh->submitJwnc();
            break;
        case 'do-chem':
            $coshh->showForm("chemical");
            break;
        case 'do-bio':
            $coshh->showForm("bio");
            break;
        case 'do-general':
            $coshh->showForm("general");
            break;
        case 'do-jwnc':
            $coshh->showJwnc($_GET['type']);
            break;
        default:
            $coshh->showIndex();
            break;
    }
}

?>
