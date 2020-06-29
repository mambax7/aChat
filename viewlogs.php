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

use XoopsModules\Achat\PageNav;

require __DIR__ . '/header.php';

$GLOBALS['xoopsOption']['template_main'] = 'achat_viewlogs.tpl';
require XOOPS_ROOT_PATH . '/header.php';

$start    = !empty($_GET['start']) ? (int)$_GET['start'] : 0;
$limit    = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 30;
$limit    = empty($limit) ? 30 : $limit;
$order    = ('ASC' == $_GET['order']) ? 'ASC' : 'DESC';
$criteria = new Criteria('mid', 0, '>');
$criteria->setLimit($limit);
$criteria->setOrder($order);
$criteria->setStart($start);

$messageObjArray  = $messageHandler->getObjects($criteria);
$count    = $messageHandler->getCount($criteria);
$messages = $messageHandler->getMessagesForDisplay($messageObjArray);
$nav = new PageNav($count, $limit, $start, $order);

$xoopsTpl->assign('pagenav', $nav->renderAuto(5, true));
$xoopsTpl->assign('pagenav2', $nav->renderNav(5));
$xoopsTpl->assign('messages', $messages);

include(XOOPS_ROOT_PATH . '/footer.php');
