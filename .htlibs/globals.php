<?php

    $developmode = "devel";  // or "devel" or "production"
    //$developmode = "devel";  // or "devel" or "production"

    if ($developmode == "production") {
        define('SMARTY_DIR',"/var/www/html/tools/risk/smarty/");
        define('APP_DIR',"/var/www/html/tools/risk/");
    }
    else {
        define('SMARTY_DIR',"/var/www/html/tools/risk/smarty/");
        define('APP_DIR',"/var/www/html/tools/risk/");
    }
    include(APP_DIR . ".htlibs/setup.php");

?>
