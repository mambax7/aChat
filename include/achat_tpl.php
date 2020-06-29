<?php

declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * Module: Achat
 *
 * @category        Module
 * @author          Niluge_Kiwi (kiwiiii@gmail.com)
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Achat\Utility;

defined('XOOPS_ROOT_PATH') || die();

Utility::getJsCssHeaders($xoopsModuleConfig['tmp_refresh']);
if (isset($postmessage)) {
    $xoopsTpl->assign('postmessage', $postmessage);
}
$xoopsTpl->assign('messages', $messages);
// Gestion des droits d'envoie des messages
$groups       = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$module_id    = $xoopsModule->getVar('mid');
$grouppermHandler = xoops_getHandler('groupperm');
$achatForm   = '';
if ($grouppermHandler->checkRight('aChatCanPost', 0, $groups, $module_id)) {
    require XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/include/achat_form.php';
    $achatForm = $aform->render();
}
$xoopsTpl->assign('achatForm', $achatForm);
