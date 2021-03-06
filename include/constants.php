<?php
// Constants
define("DB_SERVER", "localhost");
define("DB_USER", "DB2");
define("DB_PASS", "emG3M4GB");
define("DB_NAME", "DB2");

define("PATH_INC", "include/");
define("PATH_MOD", "include/modules/");
define("PATH_UPLOAD", "uploads/");

define("PATH_GROUP", "content/group/");

define("PATH_CONTENT", "content/main/");
define("PATH_LEFTBOX", "content/leftbox/");
define("PATH_RIGHTBOX", "content/rightbox/");
define("PATH_FOOTER", "content/footer/");

include(PATH_MOD . "db.php");
include(PATH_MOD . "session.php");
include(PATH_MOD . "cookies.php");
include(PATH_MOD . "header.php");
include(PATH_MOD . "menu.php");
include(PATH_INC . "security.php");
include(PATH_INC . "action.php");
include(PATH_INC . "frame.php");
?>