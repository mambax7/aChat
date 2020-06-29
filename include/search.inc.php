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
/**
 *  achat_search
 *
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array|bool
 */
function achat_search($queryarray, $andor, $limit, $offset, $userid)
{
    $sql = 'SELECT mid, uname FROM ' . $GLOBALS['xoopsDB']->prefix('achat_messages') . ' WHERE _online = 1';
    if (0 !== $userid) {
        $sql .= ' AND _submitter=' . (int)$userid;
    }
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= ' AND (()';
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= '()';
        }
        $sql .= ')';
    }
    $sql    .= ' ORDER BY mid DESC';
    $result = $GLOBALS['xoopsDB']->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    while (false !== ($myrow = $GLOBALS['xoopsDB']->fetchArray($result))) {
        $ret[$i]['image'] = 'assets/images/icons/32/_search.png';
        $ret[$i]['link']  = 'messages.php?mid=' . $myrow['mid'];
        $ret[$i]['title'] = $myrow['uname'];
        ++$i;
    }
    return $ret;
}
