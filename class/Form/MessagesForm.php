<?php

declare(strict_types=1);

namespace XoopsModules\Achat\Form;

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

use Xmf\Module\Helper\Permission;
use Xmf\Request;
use XoopsFormButton;
use XoopsFormColorPicker;
use XoopsFormDateTime;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelectUser;
use XoopsFormText;
use XoopsModules\Achat;
use XoopsThemeForm;

require_once dirname(dirname(__DIR__)) . '/include/common.php';
$moduleDirName = basename(dirname(dirname(__DIR__)));
//$helper = Achat\Helper::getInstance();
$permHelper = new Permission();
xoops_load('XoopsFormLoader');

/**
 * Class MessagesForm
 */
class MessagesForm extends XoopsThemeForm
{
    public $targetObject;
    public $helper;

    /**
     * Constructor
     *
     * @param $target
     */
    public function __construct($target)
    {
        $this->helper       = $target->helper;
        $this->targetObject = $target;
        $title              = $this->targetObject->isNew() ? sprintf(AM_ACHAT_MESSAGES_ADD) : sprintf(AM_ACHAT_MESSAGES_EDIT);
        parent::__construct($title, 'form', xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden('mid', $this->targetObject->getVar('mid'));
        $this->addElement($hidden);
        unset($hidden);
        // Mid
        $this->addElement(new XoopsFormLabel(AM_ACHAT_MESSAGES_MID, $this->targetObject->getVar('mid'), 'mid'));
        // Uid
        $this->addElement(new XoopsFormSelectUser(AM_ACHAT_MESSAGES_UID, 'uid', false, $this->targetObject->getVar('uid'), 1, false), false);
        // Uname
        $this->addElement(new XoopsFormText(AM_ACHAT_MESSAGES_UNAME, 'uname', 50, 255, $this->targetObject->getVar('uname')), false);
        // Msg
        $this->addElement(new XoopsFormText(AM_ACHAT_MESSAGES_MSG, 'msg', 50, 255, $this->targetObject->getVar('msg')), false);
        // Color
        $this->addElement(new XoopsFormColorPicker(AM_ACHAT_MESSAGES_COLOR, 'color', $this->targetObject->getVar('color')), false);
        // Date
        $this->addElement(new XoopsFormDateTime(AM_ACHAT_MESSAGES_DATE, 'date', 0, $this->targetObject->getVar('date')));
        // Ip
        $this->addElement(new XoopsFormText(AM_ACHAT_MESSAGES_IP, 'ip', 50, 255, $this->targetObject->getVar('ip')), false);
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}
