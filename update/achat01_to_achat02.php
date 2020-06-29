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
/**
 * @param $xoopsMod
 * @param $oldversion
 * @return bool
 */
function xoops_module_update_achat($xoopsMod, $oldversion)
{
    global $xoopsDB;
    $bool = true;
    $bool = $bool && $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('achat_messages') . ' CHANGE `mid` `mid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    if (010 == $oldversion) {
        $bool = $bool && $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('achat_messages') . " ADD `uname` varchar ( 60 ) DEFAULT '' AFTER `uid`");
    }
    return $bool;
}
