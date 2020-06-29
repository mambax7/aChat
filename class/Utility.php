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
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use Xmf\Request;
use XoopsModules\Achat;
use XoopsModules\Achat\Common;
use XoopsModules\Achat\Helper;
use XoopsModules\Achat\Constants;

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    //--------------- Custom module methods -----------------------------
    /**
     * Returns the allowed colors for messages
     *
     * @author           Niluge_KiWi
     * @copyright    (c) The Xoops Project - www.xoops.org
     */
    public static function getAllowedColors()
    {
        $allowed_colors = Utility::getModuleOptions('allowed_colors');
        $colors         = (1 == count($allowed_colors) && '' == $allowed_colors[0]) ? ['000000', 'dc0000', '4cb5e8', '6600cc', '336600', '000099', 'ff6600', '660000'] : $allowed_colors;
        return $colors;
    }

    /**
     * Returns the ip of the member
     *
     * @author           Niluge_KiWi
     * @copyright    (c) The Xoops Project - www.xoops.org
     */
    public static function getIp()
    {
        global $_SERVER;
        if ($_SERVER) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = xoops_getenv('REMOTE_ADDR');
        }
        return $ip;
    }

    /**
     * Returns the last color used by the member
     *
     * @author           Niluge_KiWi
     * @copyright    (c) The Xoops Project - www.xoops.org
     */
    public static function getLastColor()
    {
        global $messageHandler, $xoopsUser;
        /** @var Helper $helper */
        $helper = Helper::getInstance();
        if (!is_object($messageHandler)) {
            /** @var \XoopsPersistableObjectHandler $messageHandler */
            $messageHandler = $helper->getHandler('Message');
        }
        $msgObj = $messageHandler->getLastPost();
        return $msgObj->getVar('color');
    }

    /**
     * Returns true if xoops version >= 2.0.14
     *
     * @author           Niluge_KiWi
     * @copyright    (c) The Xoops Project - www.xoops.org
     */
    public static function getXoopsVersion()
    {
        $xoops_version_int   = mb_substr(XOOPS_VERSION, 6, 1);
        $xoops_version_float = mb_substr(XOOPS_VERSION, 8);
        $xoops_version       = $xoops_version_int . '.' . str_replace('.', '', $xoops_version_float);
        return $xoops_version >= 2.014;
    }

    /**
     * Returns like unescape javascript function, to allow 2 bytes characters
     *
     * @From http://pure-essence.net/stuff/code/utf8RawUrlDecode.phps
     * @param mixed $source
     */
    public static function decodeUrlUtf8Raw($source)
    {
        $decodedStr = '';
        $pos        = 0;
        $len        = mb_strlen($source);
        while ($pos < $len) {
            $charAt = mb_substr($source, $pos, 1);
            if ('%' == $charAt) {
                $pos++;
                $charAt = mb_substr($source, $pos, 1);
                if ('u' == $charAt) {
                    // we got a unicode character
                    $pos++;
                    $unicodeHexVal = mb_substr($source, $pos, 4);
                    $unicode       = hexdec($unicodeHexVal);
                    $entity        = '&#' . $unicode . ';';
                    $decodedStr    .= utf8_encode($entity);
                    $pos           += 4;
                } else {
                    // we have an escaped ascii character
                    $hexVal     = mb_substr($source, $pos, 2);
                    $decodedStr .= chr(hexdec($hexVal));
                    $pos        += 2;
                }
            } else {
                $decodedStr .= $charAt;
                $pos++;
            }
        }
        return $decodedStr;
    }

    /**
     * Returns a module's option
     *
     * Return's a module's option (for the aChat module)
     *
     * @ From package News
     * @param string $option module option's name
     * @param mixed  $repmodule
     * @return false|mixed
     * @return false|mixed
     * @author           Hervé Thouzard (www.herve-thouzard.com)
     *                       Modified by Niluge_KiWi : évite les conflits si différents modules ont des options en commun (même nom)
     * @copyright    (c) The Xoops Project - www.xoops.org
     */
    public static function getModuleOptions($option, $repmodule = 'aChat')
    {
        global $xoopsModuleConfig, $xoopsModule;
        static $tbloptions = [[]];
        if (is_array($tbloptions) && array_key_exists($repmodule, $tbloptions) && array_key_exists($option, $tbloptions[$repmodule])) {
            return $tbloptions[$repmodule][$option];
        }
        $retval = false;
        if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
            if (isset($xoopsModuleConfig[$option])) {
                $retval = $xoopsModuleConfig[$option];
            }
        } else {
            $moduleHandler = xoops_getHandler('module');
            $module        = $moduleHandler->getByDirname($repmodule);
            $configHandler = xoops_getHandler('config');
            if ($module) {
                $moduleConfig = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
                if (isset($moduleConfig[$option])) {
                    $retval = $moduleConfig[$option];
                }
            }
        }
        $tbloptions[$repmodule][$option] = $retval;
        return $retval;
    }

    // Gestion des headers (javascript et css)

    /**
     * @param int $tmp_refresh
     */
    public static function getJsCssHeaders($tmp_refresh = 15)
    {
        global $xoTheme, $xoopsTpl;
        $achat_url = XOOPS_URL . '/modules/achat/';
        if (isset($xoTheme) && is_object($xoTheme)) {
            $xoTheme->addScript(
                '',
                ['type' => 'text/javascript'],
                '	var achat_url = "' . XOOPS_URL . '/modules/achat";
   	var achat_tmp_refresh = ' . $tmp_refresh . ';'
            );
            $xoTheme->addScript($achat_url . '/assets/js/XHRConnection.js');
            $xoTheme->addScript($achat_url . '/assets/js/functions.js');
            $xoTheme->addStylesheet($achat_url . '/assets/css/achat.css');
        } elseif (isset($xoopsTpl) && is_object($xoopsTpl)) {    // Compatibilité avec les anciennes versions de Xoops
            $achat_module_header = '   <link rel="stylesheet" type="text/css" href="' . $achat_url . '/assets/css/achat.css">
   <script type="text/javascript">
   	var achat_url = "' . XOOPS_URL . '/modules/achat";
   	var achat_tmp_refresh = ' . $tmp_refresh . ';
   </script>
   <script src="' . $achat_url . '/assets/js/XHRConnection.js" type="text/javascript"></script>
   <script src="' . $achat_url . '/assets/js/functions.js" type="text/javascript"></script>';
            $xoopsTpl->assign('xoops_module_header', $achat_module_header);
        }
    }






    /**
     * @param string $header
     * @param        $currentoption
     */
    public static function getAdminmenu($header, $currentoption)
    {
        /* Nice buttons styles */
        echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:12px; line-height:normal; border-top: 1px solid #b7ae88; border-left: 1px solid #b7ae88; border-right: 1px solid #b7ae88; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/achat/assets/images/bg.gif') repeat-x left bottom; font-size:12px; line-height:normal; border-left: 1px solid #b7ae88; border-right: 1px solid #b7ae88; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/achat/assets/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #b7ae88; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/achat/assets/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";
        global $xoopsModule, $xoopsConfig;
        $myts                      = \MyTextSanitizer::getInstance();
        $tblColors                 = array_fill(0, 8, '');
        $tblColors[$currentoption] = 'current';
        require __DIR__ . '/menu.php';
        echo "<div id='buttontop'>";
        echo '<table style="width: 100%; padding: 0; " cellspacing="0"><tr>';
        echo '<td style="font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px; valign: top;">';
        for ($i = 0; $i < count($headermenu); $i++) {
            echo '<a class="nobutton" href="' . $headermenu[$i]['link'] . '">' . $headermenu[$i]['title'] . '</a> ';
            if ($i < count($headermenu) - 1) {
                echo '| ';
            }
        }
        echo '<td style="font-size: 12px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;"><b>' . $xoopsModule->name() . ' ' . _AM_ACHAT_MODULEADMIN . '</b> ' . $header . '</td>';
        echo '</tr></table>';
        echo '</div>';
        echo "<div id='buttonbar'>";
        echo '<ul>';
        for ($i = 0; $i < count($adminmenu); $i++) {
            echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/' . $adminmenu[$i]['link'] . '"><span>' . $adminmenu[$i]['title'] . '</span></a></li>';
        }
        echo '</ul></div>';
        echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
    }

    public static function getAdminFooter()
    {
        echo '<p>';
        OpenTable();
        echo '<div style="text-align: center; vertical-align: center">';
        echo _AM_ACHAT_CREDIT;
        echo '</div>';
        CloseTable();
        echo '</div>';
    }

    /**
     * @param $n
     * @return mixed|void|bool|string[]|string
     */
    public static function exportText($n)
    {
        // fonction qui renvoie un fichier txt contenant les $n 1ers messages
        global $xoopsDB, $xoopsUser, $xoopsModuleConfig, $myts;
        require_once XOOPS_ROOT_PATH . '/class/template.php';
        // Configuration de l'affichage des messages
        $html    = 0;
        $smiley  = $xoopsModuleConfig['use_smilies'];
        $bbcodes = $xoopsModuleConfig['use_bbcodes'];
        // Gestion du template
        $xoopsTpl = new \XoopsTpl();
        $xoopsTpl->assign('title', _MD_ACHAT_TITLE);
        // Gestion du contenu depuis la base de donnée
        //$result = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( "achat_messages" ) . " ORDER BY mid ASC", $n);
        $result = $xoopsDB->query('SELECT min(mid) FROM ' . $xoopsDB->prefix('achat_messages'));
        [$minmid] = $xoopsDB->fetchRow($result);
        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('achat_messages') . ' WHERE mid < ' . (int)$n . '+' . $minmid);
        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            $myrow['uname'] = empty($myrow['uname']) ? \XoopsUser::getUnameFromId($myrow['uid']) : $myrow['uname'];
            $myrow['msg']   = $myts->displayTarea($myrow['msg'], $html, $smiley, $bbcodes);
            $myrow['date']  = formatTimestamp($myrow['date']);
            $sortie[]       = $myrow;
        }
        $xoopsTpl->assign('messages', $sortie);
        $texte = $xoopsTpl->fetch('db:achat_viewlogs.tpl');
        return $texte;
    }

    /**
     * @param $name
     * @param $content
     * @return bool
     */
    public static function createFile($name, $content)
    {
        if ($fh = @fopen($name, 'wb')) {
            fwrite($fh, $content);
            fclose($fh);
            return true;
        }
        return false;
    }

    /**
     * @param $n
     * @return bool|\mysqli_result
     */
    public static function purgeMessage($n)
    {
        global $xoopsDB;
        //$sql = "DELETE FROM " . $xoopsDB -> prefix( "achat_messages" ) . " ORDER BY mid ASC LIMIT " . intval($n);
        $result = $xoopsDB->query('SELECT min(mid) FROM ' . $xoopsDB->prefix('achat_messages'));
        [$minmid] = $xoopsDB->fetchRow($result);
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('achat_messages') . ' WHERE mid < ' . (int)$n . '+' . $minmid;
        return $xoopsDB->queryF($sql);
    }

    /**
     * @param $mid
     * @return bool|\mysqli_result
     */
    public static function deleteMessage($mid)
    {
        global $xoopsDB;
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('achat_messages') . ' WHERE mid = ' . (int)$mid . '';
        return $xoopsDB->queryF($sql);
    }

    /**
     * @return mixed
     */
    public static function getMessageCount()
    {
        global $xoopsDB;
        $result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('achat_messages') . '');
        [$count] = $xoopsDB->fetchRow($result);
        return $count;
    }

    /** From wf downloads
     * save_Permissions()
     *
     * @param $groups
     * @param $perm_name
     * @return
     **/
    public static function savePermissions($groups, $perm_name)
    {
        $result       = true;
        $moduleHandler      = xoops_getHandler('module');
        $module       = $moduleHandler->getByDirname('achat');
        $module_id    = $module->getVar('mid');
        $grouppermHandler = xoops_getHandler('groupperm');
        /*
        * First, if the permissions are already there, delete them
        */
        $grouppermHandler->deleteByModule($module_id, $perm_name, 0);
        /*
        *  Save the new permissions
        */
        if (is_array($groups)) {
            foreach ($groups as $group_id) {
                $grouppermHandler->addRight($perm_name, 0, $group_id, $module_id);
            }
        }
        return $result;
    }

}
