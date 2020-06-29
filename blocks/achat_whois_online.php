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

use XoopsModules\Achat\Helper;

// include the default language file
xoops_loadLanguage('main', 'achat');

/**
 * @param $options
 * @return array|false
 */
function b_achat_whois_online_show($options)
{
    // Modified from online system block
    global $xoopsUser, $xoopsModule;
    /** @var Helper $helper */
    if (!class_exists(Helper::class)) {
        return false;
    }
    $onlineHandler = xoops_getHandler('online');
    // // mt_srand((double)microtime()*1000000);
    // Additions
    // update time
    $refreshtime = null !== (int)$options[0] ? (int)$options[0] : 300;
    $onlineHandler->gc($refreshtime);
    if (is_object($xoopsUser)) {
        $uid   = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
    } else {
        $uid   = 0;
        $uname = '';
    }
    $onlineHandler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
    $onlines = &$onlineHandler->getAll();
    if (false !== $onlines) {
        $total   = count($onlines);
        $block   = [];
        $guests  = 0;
        $members = '';
        for ($i = 0; $i < $total; $i++) {
            if ($onlines[$i]['online_uid'] > 0) {
                $members .= ' <a href="' . XOOPS_URL . '/userinfo.php?uid=' . $onlines[$i]['online_uid'] . '">' . $onlines[$i]['online_uname'] . '</a>,';
            } else {
                $guests++;
            }
        }
        $block['online_total'] = sprintf(_ONLINEPHRASE, $total);
        if (is_object($xoopsModule)) {
            $mytotal               = $onlineHandler->getCount(new Criteria('online_module', $xoopsModule->getVar('mid')));
            $block['online_total'] .= ' (' . sprintf(_ONLINEPHRASEX, $mytotal, $xoopsModule->getVar('name')) . ')';
        }
        $block['lang_members']   = _MEMBERS;
        $block['lang_guests']    = _GUESTS;
        $block['online_names']   = $members;
        $block['online_members'] = $total - $guests;
        $block['online_guests']  = $guests;
        $block['lang_more']      = _MORE;
        return $block;
    }
    return false;
}

/**
 * @param $options
 * @return string
 */
function b_achat_whois_online_edit($options)
{
    $form = _MB_ACHAT_TMP_REFRESH . ":&nbsp;<input type='text' name='options[0]' size='4' value='" . $options[0] . "'><br>&nbsp;&nbsp;" . _MB_ACHAT_TMP_REFRESHDESC;
    return $form;
}
