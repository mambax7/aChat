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

/**
 * @param $options
 *
 * @return array
 */
function showAchatMessages($options)
{
    // require dirname(__DIR__) . '/class/messages.php';
    ///  $moduleDirName = basename(dirname(__DIR__));
    //$myts = \MyTextSanitizer::getInstance();
    $block         = [];
    $blockType     = $options[0];
    $messagesCount = $options[1];
    //$titleLenght = $options[2];
    /** @var Helper $helper */
    if (!class_exists(Helper::class)) {
        return false;
    }
    $helper = Helper::getInstance();
    /** @var \XoopsPersistableObjectHandler $messagesHandler */
    $messagesHandler = $helper->getHandler('Messages');
    $criteria        = new \CriteriaCompo();
    array_shift($options);
    array_shift($options);
    array_shift($options);
    if ($blockType) {
        $criteria->add(new \Criteria('mid', 0, '!='));
        $criteria->setSort('mid');
        $criteria->setOrder('ASC');
    }
    $criteria->setLimit($messagesCount);
    $messagesArray = $messagesHandler->getAll($criteria);
    foreach (array_keys($messagesArray) as $i) {
    }
    return $block;
}

/**
 * @param $options
 *
 * @return string
 */
function editMessages($options)
{
    //require dirname(__DIR__) . '/class/messages.php';
    // $moduleDirName = basename(dirname(__DIR__));
    $form = MB_ACHAT_DISPLAY;
    $form .= "<input type='hidden' name='options[0]' value='" . $options[0] . "' >";
    $form .= "<input name='options[1]' size='5' maxlength='255' value='" . $options[1] . "' type='text' >&nbsp;<br>";
    $form .= MB_ACHAT_TITLELENGTH . " : <input name='options[2]' size='5' maxlength='255' value='" . $options[2] . "' type='text' ><br><br>";
    /** @var Helper $helper */
    $helper = Helper::getInstance();
    /** @var \XoopsPersistableObjectHandler $messagesHandler */
    $messagesHandler = $helper->getHandler('Messages');
    $criteria        = new \CriteriaCompo();
    array_shift($options);
    array_shift($options);
    array_shift($options);
    $criteria->add(new \Criteria('mid', 0, '!='));
    $criteria->setSort('mid');
    $criteria->setOrder('ASC');
    $messagesArray = $messagesHandler->getAll($criteria);
    $form          .= MB_ACHAT_CATTODISPLAY . "<br><select name='options[]' multiple='multiple' size='5'>";
    $form          .= "<option value='0' " . (false === in_array(0, $options) ? '' : "selected='selected'") . '>' . MB_ACHAT_ALLCAT . '</option>';
    foreach (array_keys($messagesArray) as $i) {
        $mid  = $messagesArray[$i]->getVar('mid');
        $form .= "<option value='" . $mid . "' " . (false === in_array($mid, $options) ? '' : "selected='selected'") . '>' . $messagesArray[$i]->getVar('uname') . '</option>';
    }
    $form .= '</select>';
    return $form;
}
