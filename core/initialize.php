<?php 

// define names constants (to be used in other areas of the api)
// DS = / or \ depending on server OS/config
// SITE_ROOT = root directory of project
defined("DS") ? null : define("DS",DIRECTORY_SEPARATOR);
defined("SITE_ROOT") ? null : define("SITE_ROOT", DS."Applications".DS."mamp".DS."htdocs".DS."API-2025");

// to be used to include all necessary files for api to be started
defined("CORE_PATH") ? null : define("CORE_PATH",SITE_ROOT.DS."core");
defined("INC_PATH") ? null : define("INC_PATH",SITE_ROOT.DS."includes");

// load config file first for db connection
require_once(CORE_PATH.DS."config.php");

// load classes
require_once(INC_PATH.DS."user.php");

?>