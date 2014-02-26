<?php

/**
 * Setup for the coshh db
 *
 **/

require(APP_DIR . ".htlibs/coshh_lib.php");
require(SMARTY_DIR . "Smarty.class.php");

class personsDB_Smarty extends Smarty
{

    function __construct()
    {
        parent::__construct();
        $this->template_dir = APP_DIR . 'templates';
        $this->compile_dir = APP_DIR . 'templates_c';
        $this->config_dir = APP_DIR . 'configs';
        $this->cache_dir = APP_DIR . 'cache';
    }

}


?>
