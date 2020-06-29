<?php

declare(strict_types=1);

namespace XoopsModules\Achat;

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

/**
 * aChat Message class
 *
 * Inspired from message.php from Discuss module.
 */
class Message extends \XoopsObject
{
    /**
     * constructor
     * @access public
     */
    public function __construct()
    {
        // call parent constructor
        parent::__construct();
        // define object elements
        $this->initVar('mid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('uname', XOBJ_DTYPE_TXTBOX, null, false, 60);
        $this->initVar('msg', XOBJ_DTYPE_OTHER, null, true, 255);
        $this->initVar('color', XOBJ_DTYPE_TXTBOX, '000000', false);
        $this->initVar('date', XOBJ_DTYPE_INT, null, true);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX, '0.0.0.0', true, 15);
    }

    // checkVar

    /**
     * @param $value
     * @return bool
     */
    public function checkVar_color($value)
    {
        $colors = Utility::getAllowedColors();
        if (!in_array($value, $colors)) {
            $this->setErrors('bad color posted.');
            return false;
        }
        return true;
    }
}
