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

use Xmf\Module\Admin;
use XoopsModules\Achat;
use XoopsModules\Achat\Helper;

require dirname(__DIR__) . '/preloads/autoloader.php';
$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
/** @var Helper $helper */
$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');
// get path to icons
$pathIcon32 = Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getConfig('modicons32');
}
$adminmenu   = [];
$adminmenu[] = [
    'title' => _MI_ACHAT_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];
$adminmenu[] = [
    'title' => _MI_ACHAT_HOME,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/manage.png',
];
$adminmenu[] = [
    'title' => _MI_ACHAT_PURGE,
    'link'  => 'admin/main.php?op=purge',
    'icon'  => $pathIcon32 . '/prune.png',
];
$adminmenu[] = [
    'title' => MI_ACHAT_ADMENU2,
    'link'  => 'admin/messages.php',
    'icon'  => "{$pathIcon32}/users.png",
];
$adminmenu[] = [
    'title' => _MI_ACHAT_PERM,
    'link'  => 'admin/main.php?op=perm',
    'icon'  => $pathIcon32 . '/permissions.png',
];
$adminmenu[] = [
    'title' => _MI_ACHAT_UTILITIES,
    'link'  => 'admin/utilities.php',
    'icon'  => $pathIcon32 . '/administration.png',
];
$adminmenu[] = [
    'title' => MI_ACHAT_ADMENU3,
    'link'  => 'admin/feedback.php',
    'icon'  => "{$pathIcon32}/mail_foward.png",
];
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link'  => 'admin/blocksadmin.php',
    'icon'  => "{$pathIcon32}/block.png",
];
if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => MI_ACHAT_ADMENU4,
        'link'  => 'admin/migrate.php',
        'icon'  => "{$pathIcon32}/database_go.png",
    ];
}
$adminmenu[] = [
    'title' => MI_ACHAT_ADMENU5,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
