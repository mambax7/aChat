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
use Xmf\Request;
use Xmf\Yaml;
use XoopsModules\Achat;
use XoopsModules\Achat\Common;
use XoopsModules\Achat\Common\DirectoryChecker;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject = Admin::getInstance();
/** @var \XoopsModules\Achat\Helper $helper */
$helper->loadLanguage('directorychecker');
//count "total Messages"
/** @var \XoopsPersistableObjectHandler $messagesHandler */
$totalMessages = $messagesHandler->getCount();
// InfoBox Statistics
$adminObject->addInfoBox(AM_ACHAT_STATISTICS);
// InfoBox messages
$adminObject->addInfoBoxLine(sprintf(AM_ACHAT_THEREARE_MESSAGES, $totalMessages));

//------ check Upload Folders ---------------
$languageConstants = [
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'AVAILABLE'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'NOTAVAILABLE'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'CREATETHEDIR'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'NOTWRITABLE'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'SETMPERM'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'DIRCREATED'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'DIRNOTCREATED'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'PERMSET'),
    constant('CO_' . $moduleDirNameUpper . '_DC_' . 'PERMNOTSET'),

];

$adminObject->addConfigBoxLine('');
$redirectFile  = $_SERVER['SCRIPT_NAME'];
$configurator  = new Common\Configurator();
$uploadFolders = $configurator->uploadFolders;
//foreach (array_keys($uploadFolders) as $i) {
//    $adminObject->addConfigBoxLine(DirectoryChecker::getDirectoryStatus($uploadFolders[$i], 0777, $redirectFile));
//}

foreach ($uploadFolders as $path) {
    $adminObject->addConfigBoxLine(DirectoryChecker::getDirectoryStatus($path['dir'], $path['perm'], $languageConstants, $path['action']));
}



// Render Index
$adminObject->displayNavigation(basename(__FILE__));
//check for latest release
//$newRelease = $utility->checkVerModule($helper);
//if (!empty($newRelease)) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}
//------------- Test Data ----------------------------
if ($helper->getConfig('displaySampleButton')) {
    $yamlFile            = dirname(__DIR__) . '/config/admin.yml';
    $config              = loadAdminConfig($yamlFile);
    $displaySampleButton = $config['displaySampleButton'];
    if (1 == $displaySampleButton) {
        xoops_loadLanguage('admin/modulesadmin', 'system');
        require_once dirname(__DIR__) . '/testdata/index.php';
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), $helper->url('testdata/index.php?op=load'), 'add');
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), $helper->url('testdata/index.php?op=save'), 'add');
        //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), $helper->url( 'testdata/index.php?op=exportschema'), 'add');
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS'), '?op=hide_buttons', 'delete');
    } else {
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS'), '?op=show_buttons', 'add');
        $displaySampleButton = $config['displaySampleButton'];
    }
    $adminObject->displayButton('left', '');;
}
//------------- End Test Data ----------------------------
$adminObject->displayIndex();
function loadAdminConfig($yamlFile)
{
    $config = Yaml::readWrapped($yamlFile); // work with phpmyadmin YAML dumps
    return $config;
}

function hideButtons($yamlFile)
{
    $app                        = [];
    $app['displaySampleButton'] = 0;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

function showButtons($yamlFile)
{
    $app                        = [];
    $app['displaySampleButton'] = 1;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

$op = Request::getString('op', 0, 'GET');
switch ($op) {
    case 'hide_buttons':
        hideButtons($yamlFile);
        break;
    case 'show_buttons':
        showButtons($yamlFile);
        break;
}
echo $utility::getServerStats();
//codeDump(__FILE__);
require __DIR__ . '/admin_footer.php';
