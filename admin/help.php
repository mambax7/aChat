<?php

/** From
 * Module: myHome
 * Licence : GPL
 * Authors :
 *           - solo (http://www.wolfpackclan.com)
 */

use XoopsModules\Achat\Utility;

require_once __DIR__ . '/admin_header.php';
$myts = \MyTextSanitizer::getInstance();
xoops_cp_header();
Utility::getAdminmenu(_MI_ACHAT_HELP, -1);
OpenTable();
$helpfile = XOOPS_ROOT_PATH . '/modules/achat/language/' . $xoopsConfig['language'] . '/help.tpl';
if (file_exists($helpfile)) {
    require_once($helpfile);
} else {
    require_once(XOOPS_ROOT_PATH . '/modules/achat/language/english/help.tpl');
}
CloseTable();
require_once __DIR__ . '/admin_footer.php';
