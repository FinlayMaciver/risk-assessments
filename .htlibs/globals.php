<?php

    $developmode = "production";  // or "devel" or "production"
    //$developmode = "devel";  // or "devel" or "production"

    if ($developmode == "production") {
        define('SMARTY_DIR',"/var/www/html/tools/risk/smarty/");
        define('APP_DIR',"/var/www/html/tools/risk/");
    }
    else {
        define('SMARTY_DIR',"/var/www/html/risk/smarty/");
        define('APP_DIR',"/var/www/html/risk/");
    }
    include(APP_DIR . ".htlibs/setup.php");

?>
