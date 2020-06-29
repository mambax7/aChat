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
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Achat;
use XoopsModules\Achat\Helper;
use Xmf\Request;

require __DIR__ . '/header.php';
$op = Request::getCmd('op', 'list');
if ('edit' !== $op) {
    if ('view' === $op) {
        $GLOBALS['xoopsOption']['template_main'] = 'achat_messages.tpl';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'achat_messages_list0.tpl';
    }
}
require_once XOOPS_ROOT_PATH . '/header.php';
global $xoTheme;
$start = Request::getInt('start', 0);
// Define Stylesheet
/** @var xos_opal_Theme $xoTheme */
$xoTheme->addStylesheet($stylesheet);
$db = \XoopsDatabaseFactory::getDatabaseConnection();
// Get Handler
/** @var \XoopsPersistableObjectHandler $messagesHandler */
$messagesHandler         = $helper->getHandler('Messages');
$messagesPaginationLimit = $helper->getConfig('userpager');
$criteria                = new \CriteriaCompo();
$criteria->setOrder('DESC');
$criteria->setLimit($messagesPaginationLimit);
$criteria->setStart($start);
$messagesCount = $messagesHandler->getCount($criteria);
$messagesArray = $messagesHandler->getAll($criteria);
$mid           = Request::getInt('mid', 0, 'GET');
switch ($op) {
    case 'edit':
        $messagesObject = $messagesHandler->get(Request::getString('mid', ''));
        $form           = $messagesObject->getForm();
        $form->display();
        break;
    case 'view':
        //        viewItem();
        $messagesPaginationLimit = 1;
        $myid                    = $mid;
        //mid
        $messagesObject = $messagesHandler->get($myid);
        $criteria       = new \CriteriaCompo();
        $criteria->setSort('mid');
        $criteria->setOrder('DESC');
        $criteria->setLimit($messagesPaginationLimit);
        $criteria->setStart($start);
        $messages['mid']   = $messagesObject->getVar('mid');
        $messages['uid']   = strip_tags(\XoopsUser::getUnameFromId($messagesObject->getVar('uid')));
        $messages['uname'] = $messagesObject->getVar('uname');
        $messages['msg']   = $messagesObject->getVar('msg');
        $messages['color'] = $messagesObject->getVar('color');
        $messages['date']  = formatTimestamp($messagesObject->getVar('date'), 's');
        $messages['ip']    = $messagesObject->getVar('ip');
        //       $GLOBALS['xoopsTpl']->append('messages', $messages);
        $keywords[] = $messagesObject->getVar('uname');
        $GLOBALS['xoopsTpl']->assign('messages', $messages);
        $start = $mid;
        // Display Navigation
        if ($messagesCount > $messagesPaginationLimit) {
            $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', ACHAT_URL . '/messages.php');
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav($messagesCount, $messagesPaginationLimit, $start, 'op=view&mid');
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
        }
        break;
    case 'list':
    default:
        //        viewall();
        if ($messagesCount > 0) {
            $GLOBALS['xoopsTpl']->assign('messages', []);
            foreach (array_keys($messagesArray) as $i) {
                $messages['mid']   = $messagesArray[$i]->getVar('mid');
                $messages['uid']   = strip_tags(\XoopsUser::getUnameFromId($messagesArray[$i]->getVar('uid')));
                $messages['uname'] = $messagesArray[$i]->getVar('uname');
                $messages['msg']   = $messagesArray[$i]->getVar('msg');
                $messages['msg']   = $utility::truncateHtml($messages['msg'], $helper->getConfig('truncatelength'));
                $messages['color'] = $messagesArray[$i]->getVar('color');
                $messages['date']  = formatTimestamp($messagesArray[$i]->getVar('date'), 's');
                $messages['ip']    = $messagesArray[$i]->getVar('ip');
                $GLOBALS['xoopsTpl']->append('messages', $messages);
                $keywords[] = $messagesArray[$i]->getVar('uname');
                unset($messages);
            }
            // Display Navigation
            if ($messagesCount > $messagesPaginationLimit) {
                $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', ACHAT_URL . '/messages.php');
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav($messagesCount, $messagesPaginationLimit, $start, 'start');
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        }
}
//keywords
if (isset($keywords)) {
    $utility::metaKeywords($helper->getConfig('keywords') . ', ' . implode(', ', $keywords));
}
//description
$utility::metaDescription(MD_ACHAT_MESSAGES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', ACHAT_URL . '/messages.php');
$GLOBALS['xoopsTpl']->assign('achat_url', ACHAT_URL);
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));
$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));
$GLOBALS['xoopsTpl']->assign('admin', ACHAT_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);
require XOOPS_ROOT_PATH . '/footer.php';
