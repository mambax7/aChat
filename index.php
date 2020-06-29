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
require __DIR__ . '/header.php';

// If it is an insertion request, we insert the message!
if (isset($_POST['achat_input'])) {
    // Management of rights to send messages
    $groups       = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $module_id    = $xoopsModule->getVar('mid');
    $grouppermHandler = xoops_getHandler('groupperm');
    // If the visitor has the right to post, we record the message
    if ($grouppermHandler->checkRight('aChatCanPost', 0, $groups, $module_id)) {
        // Message depending on whether or not the message was recorded correctly.
        $postmessage = $messageHandler->processPostRequest() ? '' : 'Error: message not saved';
    }
}
// If it is an AJAX update request or a post with AJAX, we send new messages
if (isset($_POST['achat_ajax_refresh']) || isset($_POST['achat_ajax_submit'])) {
    require XOOPS_ROOT_PATH . '/header.php';
    $lastmid  = (int)$_POST['achat_lastmid'];
    $messages = $messageHandler->getMessages('from', $lastmid);
    // debug error message: put this in the url, then validate: (it displays the temporary div)
    //      javascript:change Display ('div purchase temp');
    // and uncomment the line if below (remove the //)
    //     if(isset($postmessage)) $xoopsTpl->assign('postmessage',$postmessage);
    $xoopsTpl->assign('messages', $messages);
    $xoopsTpl->assign('ajax_display', 1);
    // Disabling error messages:
    // - For xoops <= 2.0.13.2
    // - For xoops >= 2.0.14
    if (method_exists($xoopsErrorHandler, 'activate')) {
        $xoopsErrorHandler->activate(false);
    } else {
        $xoopsLogger->activated = false;
    }
    //Charset management with header:
    if (!headers_sent()) {
        header('Content-Type:text/html; charset=' . _CHARSET);
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        //header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: private, no-cache');
        header('Pragma: no-cache');
    }
    //Final display with smarty
    $xoopsTpl->display('db:achat_display.tpl');
    exit;
}
// If it is a normal opening of the page, or a post without AJAX, we display the messages
$GLOBALS['xoopsOption']['template_main'] = 'achat_display.tpl';
require XOOPS_ROOT_PATH . '/header.php';
$messages = $messageHandler->getMessages('last', $xoopsModuleConfig['nbre_msg_aff']);
require __DIR__ . '/include/achat_tpl.php';
include(XOOPS_ROOT_PATH . '/footer.php');
