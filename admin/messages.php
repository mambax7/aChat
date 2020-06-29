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

use Xmf\Module\Helper\Permission;
use Xmf\Request;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = \Xmf\Request::getString('op', 'list');
$order = \Xmf\Request::getString('order', 'desc');
$sort  = \Xmf\Request::getString('sort', '');
$adminObject->displayNavigation(basename(__FILE__));
/** @var \Xmf\Module\Helper\Permission $permHelper */
$permHelper = new Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/achat/messages/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/achat/messages/';
switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_ACHAT_MESSAGES_LIST, 'messages.php', 'list');
        $adminObject->displayButton('left');
        $messagesObject = $messagesHandler->create();
        $form           = $messagesObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('messages.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('mid', 0)) {
            $messagesObject = $messagesHandler->get(Request::getInt('mid', 0));
        } else {
            $messagesObject = $messagesHandler->create();
        }
        // Form save fields
        $messagesObject->setVar('uid', Request::getVar('uid', ''));
        $messagesObject->setVar('uname', Request::getVar('uname', ''));
        $messagesObject->setVar('msg', Request::getVar('msg', ''));
        $messagesObject->setVar('color', Request::getVar('color', ''));
        $resDate     = Request::getArray(date, [], 'POST');
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, $resDate['date']);
        $dateTimeObj->setTime(0, 0, 0);
        $messagesObject->setVar('date', $dateTimeObj->getTimestamp() + $resDate['time']);
        $messagesObject->setVar('ip', Request::getVar('ip', ''));
        if ($messagesHandler->insert($messagesObject)) {
            redirect_header('messages.php?op=list', 2, AM_ACHAT_FORMOK);
        }
        echo $messagesObject->getHtmlErrors();
        $form = $messagesObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_ACHAT_ADD_MESSAGES, 'messages.php?op=new', 'add');
        $adminObject->addItemButton(AM_ACHAT_MESSAGES_LIST, 'messages.php', 'list');
        $adminObject->displayButton('left');
        $messagesObject = $messagesHandler->get(Request::getString('mid', ''));
        $form           = $messagesObject->getForm();
        $form->display();
        break;
    case 'delete':
        $messagesObject = $messagesHandler->get(Request::getString('mid', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('messages.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($messagesHandler->delete($messagesObject)) {
                redirect_header('messages.php', 3, AM_ACHAT_FORMDELOK);
            } else {
                echo $messagesObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'mid' => Request::getString('mid', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_ACHAT_FORMSUREDEL, $messagesObject->getVar('uname')));
        }
        break;
    case 'clone':
        $id_field = \Xmf\Request::getString('mid', '');
        if ($utility::cloneRecord('achat_messages', 'mid', $id_field)) {
            redirect_header('messages.php', 3, AM_ACHAT_CLONED_OK);
        } else {
            redirect_header('messages.php', 3, AM_ACHAT_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_ACHAT_ADD_MESSAGES, 'messages.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                   = \Xmf\Request::getInt('start', 0);
        $messagesPaginationLimit = $helper->getConfig('userpager');
        $criteria                = new \CriteriaCompo();
        $criteria->setSort('mid ASC, uname');
        $criteria->setOrder('ASC');
        $criteria->setLimit($messagesPaginationLimit);
        $criteria->setStart($start);
        $messagesTempRows  = $messagesHandler->getCount();
        $messagesTempArray = $messagesHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_ACHAT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($messagesTempRows > $messagesPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $messagesTempRows, $messagesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('messagesRows', $messagesTempRows);
        $messagesArray = [];
        //    $fields = explode('|', mid:int:20::NOT NULL::primary:ID:0|uid:int:5::NOT NULL:0::UserID:1|uname:varchar:60::NULL:::Name:2|msg:varchar:255::NOT NULL:::Msg:3|color:varchar:6::NOT NULL:000000::Color:4|date:int:11:UNSIGNED:NOT NULL:0::Date:5|ip:varchar:45::NOT NULL:0.0.0.0::IP:6);
        //    $fieldsCount    = count($fields);
        $criteria = new \CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($messagesPaginationLimit);
        $criteria->setStart($start);
        $messagesCount     = $messagesHandler->getCount($criteria);
        $messagesTempArray = $messagesHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($messagesCount > 0) {
            foreach (array_keys($messagesTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign('selectormid', AM_ACHAT_MESSAGES_MID);
                $messagesArray['mid'] = $messagesTempArray[$i]->getVar('mid');
                $GLOBALS['xoopsTpl']->assign('selectoruid', AM_ACHAT_MESSAGES_UID);
                $messagesArray['uid'] = strip_tags(\XoopsUser::getUnameFromId($messagesTempArray[$i]->getVar('uid')));
                $selectoruname        = $utility::selectSorting(AM_ACHAT_MESSAGES_UNAME, 'uname');
                $GLOBALS['xoopsTpl']->assign('selectoruname', $selectoruname);
                $messagesArray['uname'] = $messagesTempArray[$i]->getVar('uname');
                $GLOBALS['xoopsTpl']->assign('selectormsg', AM_ACHAT_MESSAGES_MSG);
                $messagesArray['msg'] = $messagesTempArray[$i]->getVar('msg');
                $messagesArray['msg'] = $utility::truncateHtml($messagesArray['msg'], $helper->getConfig('truncatelength'));
                $GLOBALS['xoopsTpl']->assign('selectorcolor', AM_ACHAT_MESSAGES_COLOR);
                $messagesArray['color'] = $messagesTempArray[$i]->getVar('color');
                $selectordate           = $utility::selectSorting(AM_ACHAT_MESSAGES_DATE, 'date');
                $GLOBALS['xoopsTpl']->assign('selectordate', $selectordate);
                $messagesArray['date'] = formatTimestamp($messagesTempArray[$i]->getVar('date'), 's');
                $selectorip            = $utility::selectSorting(AM_ACHAT_MESSAGES_IP, 'ip');
                $GLOBALS['xoopsTpl']->assign('selectorip', $selectorip);
                $messagesArray['ip']          = $messagesTempArray[$i]->getVar('ip');
                $messagesArray['edit_delete'] = "<a href='messages.php?op=edit&mid=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='messages.php?op=delete&mid=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='messages.php?op=clone&mid=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('messagesArrays', $messagesArray);
                unset($messagesArray);
            }
            unset($messagesTempArray);
            // Display Navigation
            if ($messagesCount > $messagesPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $messagesCount, $messagesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            //                     echo "<td class='center width5'>
            //                    <a href='messages.php?op=edit&mid=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='messages.php?op=delete&mid=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";
            //                echo "</tr>";
            //            }
            //            echo "</table><br><br>";
            //        } else {
            //            echo "<table width='100%' cellspacing='1' class='outer'>
            //                    <tr>
            //                     <th class='center width5'>".AM_ACHAT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='8'>There are noXXX messages</td></tr>";
            //            echo "</table><br><br>";
            //-------------------------------------------
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/achat_admin_messages.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
