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

require __DIR__ . '/admin_header.php';

function achat()
{
    global $xoopsUser, $xoopsDB, $xoopsConfig, $xoopsModule, $myts;
    xoops_cp_header();
    //	Utility::getAdminmenu _MI_ACHAT_HOME, 0 );
    OpenTable();
    echo '<h1>' . _AM_ACHAT_WELCOME . '</h1>';
    echo '<div>' . _AM_ACHAT_NBRE_MSG . ':&nbsp;' . Utility::getMessageCount() . '</div>';
    CloseTable();
    echo '<p>';
    // Delete form
    $sform = new XoopsThemeForm(_AM_ACHAT_DELETEMSG, 'op', 'main.php?op=deletemsg');
    $sform->addElement(new XoopsFormText(_AM_ACHAT_DELETEMSG_MID, 'mid', 4, 6));
    $sform->addElement(new XoopsFormButton('', 'valide', _SUBMIT, 'submit'));
    $sform->display();
    require_once __DIR__ . '/admin_footer.php';
}

function deletemsg()
{
    global $_POST;
    xoops_cp_header();
    //	Utility::getAdminmenu _AM_ACHAT_DELETEMSG, -1 );
    $mid = isset($_POST['mid']) ? (int)$_POST['mid'] : false;
    OpenTable();
    if ($mid) {
        if (Utility::deleteMessage($mid)) {
            echo sprintf(_AM_ACHAT_DELETEMSG_OK, $mid);
        } else {
            echo sprintf(_AM_ACHAT_DELETEMSG_ERROR, $mid);
        }
    } else {
        echo _AM_ACHAT_EMPTY_FIELD;
    }
    CloseTable();
    require_once __DIR__ . '/admin_footer.php';
}

function purge()
{
    xoops_cp_header();
    //	Utility::getAdminmenu _MI_ACHAT_PURGE, 1 );
    OpenTable();
    echo '<div>' . _AM_ACHAT_NBRE_MSG . ':&nbsp;' . Utility::getMessageCount() . '</div>';
    CloseTable();
    echo '<p>';
    // Purge form
    $sform = new XoopsThemeForm(_AM_ACHAT_PURGEPERNBRE, 'op', 'main.php?op=purge2');
    $sform->addElement(new XoopsFormText(_AM_ACHAT_PURGE_HOWMANY, 'number', 4, 6, 100));
    $sform->addElement(new XoopsFormRadioYN(_AM_ACHAT_PURGE_CREATELOG, 'log', 1));
    $sform->addElement(new XoopsFormButton('', 'valide', _SUBMIT, 'submit'));
    $sform->display();
    echo '<p>';
    // Purge per date form
    $sform = new XoopsThemeForm(_AM_ACHAT_PURGEPERDATE, 'op', 'main.php?op=purge2');
    $sform->addElement(new XoopsFormText(_AM_ACHAT_PURGE_KEEP_HMDAYS, 'daynumbers', 4, 6, 30));
    $sform->addElement(new XoopsFormRadioYN(_AM_ACHAT_PURGE_CREATELOG, 'log', 1));
    $sform->addElement(new XoopsFormButton('', 'valide', _SUBMIT, 'submit'));
    $sform->display();
    require_once __DIR__ . '/admin_footer.php';
}

function purge2()
{
    global $_POST, $messageHandler;
    xoops_cp_header();
    //	Utility::getAdminmenu _MI_ACHAT_PURGE, 1 );
    OpenTable();
    $number     = $_POST['number'] ?? false;
    $daynumbers = $_POST['daynumbers'] ?? false;
    if ($number || $daynumbers) {
        $log = $_POST['log'];
        // 2nd purge stage: validation
        if (!isset($_POST['validated'])) {
            if (0 == $log) {
                $msgsupp = '&nbsp;' . _AM_ACHAT_PURGE_SUPPR_NOLOG;
            } else {
                $msgsupp = '';
            }
            // Purge by number:
            if ($number) {
                $sform = new XoopsSimpleForm(_AM_ACHAT_PURGE_VALIDATE . '&nbsp;' . $number . '&nbsp;' . _AM_ACHAT_MESSAGES . $msgsupp . '?', 'op', 'main.php?op=purge2');
            }
            // Purge by date:
            if ($daynumbers) {
                $date     = time() - $daynumbers * 24 * 60 * 60;
                $criteria = new Criteria('date', $date, '<');
                $number   = $messageHandler->getCount($criteria);
                $sform    = new XoopsSimpleForm(_AM_ACHAT_PURGE_VALIDATE . '&nbsp;' . _AM_ACHAT_PURGE_VALIDATE_PERDAY . $daynumbers . _AM_ACHAT_PURGE_VALIDATE_PERDAY2 . ' (' . $number . '&nbsp;' . _AM_ACHAT_MESSAGES . ') ' . $msgsupp . '?', 'op', 'main.php?op=purge2');
            }
            // If no messages to delete, we stop everything
            if (0 == $number) {
                echo _AM_ACHAT_PURGE_NOMSG . '<br>' . _AM_ACHAT_PURGE_CANCELED;
                exit;
            }
            $sform->addElement(new XoopsFormHidden('number', $number));
            $sform->addElement(new XoopsFormHidden('log', $log));
            $sform->addElement(new XoopsFormHidden('validated', 1));
            $sform->addElement(new XoopsFormButton('', 'valide', _SUBMIT, 'submit'));
            $sform->display();
            // 3rd purge stage: effective purge
        } else {
            // If logs requested
            if (1 == $log) {
                // We are trying to create the log file!
                $file_url = purge_create_log($number);
                // If the file was not created, error msg.
                if (!$file_url) {
                    echo _AM_ACHAT_PURGE_ERROR_WRITEFILE . '<br>';
                } else {
                    echo _AM_ACHAT_PURGE_LOG_WRITTEN . ':&nbsp;<a href="' . $file_url . '">' . $file_url . '</a><br>';
                }
            }
            // If the creation of the log failed, we cancel the purge
            if (isset($file_url) && !$file_url) {
                echo _AM_ACHAT_PURGE_CANCELED;
            } elseif (Utility::purgeMessage($number)) {
                echo _AM_ACHAT_PURGE_OK . '<br>' . _AM_ACHAT_PURGE_NBREMSGDEL . $number;
            } else {
                echo _AM_ACHAT_PURGE_ERROR;
            }
            echo '<div>' . _AM_ACHAT_NBRE_MSG . ':&nbsp;' . Utility::getMessageCount() . '</div>';
        }
    } else {
        echo _AM_ACHAT_EMPTY_FIELD;
    }
    CloseTable();
    require_once __DIR__ . '/admin_footer.php';
}

/**
 * @param $n
 * @return false|string
 */
function purge_create_log($n)
{
    global $xoopsDB, $xoopsModuleConfig;
    $texte        = Utility::exportText($n);
    $purge_folder = rtrim(ltrim($xoopsModuleConfig['purge_folder'], '/'), '/');
    $rep          = empty($purge_folder) ? XOOPS_ROOT_PATH . '/modules/achat/logs' : XOOPS_ROOT_PATH . '/' . $purge_folder;
    $result       = $xoopsDB->query('SELECT date FROM ' . $xoopsDB->prefix('achat_messages') . ' ORDER BY mid ASC', 1);
    [$startdate] = $xoopsDB->fetchRow($result);
    $result = $xoopsDB->query('SELECT date FROM ' . $xoopsDB->prefix('achat_messages') . ' ORDER BY mid ASC', 1, (int)$n - 1);
    [$enddate] = $xoopsDB->fetchRow($result);
    $file = 'achat_logs_-_';
    $file .= $startdate . '_to_' . $enddate . '.html';
    $name = $rep . '/' . $file;
    if (Utility::createFile($name, $texte)) {
        $rep2 = empty($purge_folder) ? XOOPS_URL . '/modules/achat/logs' : XOOPS_URL . '/' . $purge_folder;
        return $rep2 . '/' . $file;
    }
    return false;
}

function perm()
{
    global $xoopsModule;
    require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
    xoops_cp_header();
    //Utility::getAdminmenu _MI_ACHAT_PERM, 2 );
    $module_id = $xoopsModule->getVar('mid');
    $perm_form = new XoopsGroupPermForm('', $module_id, 'aChatCanPost', '', 'admin/main.php?op=perm');
    $perm_form->addItem(1, _AM_ACHAT_PERM_CANPOST, 0);
    echo $perm_form->render();
    require_once __DIR__ . '/admin_footer.php';
}

$op = 'main';
$op = $_POST['op'] ?? (isset($_GET['op']) ? $_GET['op'] : 'main');
switch ($op) {
    case 'purge':
        purge();
        break;
    case 'purge2':
        purge2();
        break;
    case 'deletemsg':
        deletemsg();
        break;
    case 'perm':
        perm();
        break;
    case 'main':
    default:
        achat();
        break;
}
