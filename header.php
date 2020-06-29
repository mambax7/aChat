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

use XoopsModules\Achat;
use XoopsModules\Achat\Helper;
use XoopsModules\Achat\Utility;

include __DIR__ . '/preloads/autoloader.php';

require  dirname(dirname(__DIR__)) . '/mainfile.php';

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

require XOOPS_ROOT_PATH . '/header.php';

$moduleDirName = basename(__DIR__);

/** @var Helper $helper */
$helper = Helper::getInstance();

/** @var \XoopsPersistableObjectHandler $messageHandler */
$messageHandler = $helper->getHandler('Message');
/** @var \XoopsPersistableObjectHandler $messagesHandler */
$messagesHandler = $helper->getHandler('Messages');

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/class/formachat.php';
