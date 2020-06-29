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

use XoopsModules\Achat\Form\AchatForm;


defined('XOOPS_ROOT_PATH') || die();

$textformsize = $textformsize ?? 30;
$aform        = new \XoopsSimpleForm('', 'achatform', 'index.php', 'post');
$aform->setExtra('onsubmit="checkInput();return false"');
$aform->addElement(new AchatForm($textformsize), true);
