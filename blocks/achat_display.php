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
use XoopsModules\Achat\Utility;

// include the default language file
xoops_loadLanguage('main', 'achat');

/**
 * @param $options
 * @return array
 */
function b_achat_display_show($options)
{
    // This function manages the 2 blocks:
    // - the active with autorefresh and sends messages
    // - and the passive with only static display of the last messages
    global $xoopsUser;
    /** @var Helper $helper */
    if (!class_exists(Helper::class)) {
        return false;
    }
    //Block type management
    $isactive = 1 == $options[0];
    $myts     = \MyTextSanitizer::getInstance();
    $helper = Helper::getInstance();
    /** @var \XoopsPersistableObjectHandler $messageHandler */
    $messageHandler = $helper->getHandler('Message');
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//    if ($isactive) {
//        require_once XOOPS_ROOT_PATH . '/modules/achat/class/formachat.php';
//    }
    $block = [];
    // Management of javascript and css variables if active block
    if ($isactive) {
        if (!empty($options[3])) {
            //$block['tmp_refresh']
            $tmp_refresh = (float)$options[3];
        } else {
            $tmp_refresh = Utility::getModuleOptions('tmp_refresh');
            $tmp_refresh = !empty($tmp_refresh) ? (int)$tmp_refresh : 15;
        }
        $block['div_height'] = !empty($options[2]) ? (int)$options[2] : 180;
        Utility::getJsCssHeaders($tmp_refresh);
    }
    // Number of messages displayed
    $n = !empty($options[1]) ? (int)$options[1] : Utility::getModuleOptions('nbre_msg_aff');
    // Retrieving messages
    $messages          = $messageHandler->getMessages('last', $n);
    $block['messages'] = $messages;
    if ($isactive) {
        $textformsize = !empty($options[4]) ? (int)$options[4] : 23;
        // Management of rights to send messages
        $groups              = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $moduleHandler       = xoops_getHandler('module');
        $module              = $moduleHandler->getByDirname('achat');
        $module_id           = $module->getVar('mid');
        $grouppermHandler        = xoops_getHandler('groupperm');
        $block['achatForm'] = '';
        if ($grouppermHandler->checkRight('aChatCanPost', 0, $groups, $module_id)) {
            require XOOPS_ROOT_PATH . '/modules/achat/include/achat_form.php';
            $block['achatForm'] = $aform->render();
        }
    }
    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_achat_display_edit($options)
{
    $form = "<input type='hidden' name='options[0]' value='" . $options[0] . "'>";
    $form .= '&nbsp;' . _MB_ACHAT_NBRE_MSG_AFFICHE . ":&nbsp;<input type='text' name='options[1]' size='4' value='" . $options[1] . "'><br>&nbsp;&nbsp;" . _MB_ACHAT_NBRE_MSG_AFFICHEDESC;
    if (1 == $options[0]) {
        $form .= '<br>&nbsp;' . _MB_ACHAT_DIV_HEIGHT . ":&nbsp;<input type='text' name='options[2]' size='4' value='" . $options[2] . "'><br>&nbsp;&nbsp;" . _MB_ACHAT_DIV_HEIGHTDESC;
        $form .= '<br>&nbsp;' . _MB_ACHAT_TMP_REFRESH . ":&nbsp;<input type='text' name='options[3]' size='4' value='" . $options[3] . "'><br>&nbsp;&nbsp;" . _MB_ACHAT_TMP_REFRESHDESC;
        $form .= '<br>&nbsp;' . _MB_ACHAT_DIV_WIDTH . ":&nbsp;<input type='text' name='options[4]' size='4' value='" . $options[4] . "'><br>&nbsp;&nbsp;" . _MB_ACHAT_DIV_WIDTHDESC;
    }
    return $form;
}
