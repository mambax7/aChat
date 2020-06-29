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
 * @author          Niluge_Kiwi (kiwiiii@gmail.com)
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Achat\Utility;

/**
 * A aChat form :
 *
 * aChat
 */
class AchatForm extends \XoopsFormText
{
    /**
     * AchatForm constructor.
     * @param int    $size
     * @param string $value
     */
    public function __construct($size = 30, $value = '')
    {
        parent::__construct('', 'achat_input', $size, 255, $value);
    }

    /**
     * Prepare HTML for output
     *
     * @return    string  HTML
     */
    public function render()
    {
        $ret      = $this->_renderUname_Input();
        $enterkey = '';
        if (!empty($ret)) {
            $enterkey = ' onKeyPress="submitEnter(event)"';
        }
        $ret .= '<input type="text" name="' . $this->getName() . '" id="' . $this->getName() . '" size="' . $this->getSize() . '" maxlength="' . $this->getMaxlength() . '" value="' . $this->getValue() . '"' . $enterkey . ' accesskey="N">';
        $ret .= '<input class="formButton" name="achat_submit" id="achat_submit" value="' . _MD_ACHAT_SENDMSG . '" type="button" onclick="checkInput();">';
        $ret .= '&nbsp;&nbsp;<a href="javascript:;" onclick="changeDisplay(\'achat_options_box\');">' . _OPTIONS . '</a><br><div id="achat_options_box" style="display: none;">';
        $ret .= $this->_renderSmileys();
        $ret .= $this->_renderColor_Box();
        $ret .= '</div>';
        return $ret;
    }

    /**
     * prepare HTML for output of the smiley list.
     *
     * @return string HTML
     * taken from     formdhtmltextarea.php,v 1.13.24.1 2005/08/15 15:04:58 skalpa Exp
     */
    public function _renderSmileys()
    {
        $myts   = \MyTextSanitizer::getInstance();
        $smiles = $myts->getSmileys();
        $ret    = '';
        if (empty($smileys)) {
            $db = \XoopsDatabaseFactory::getDatabaseConnection();
            if ($result = $db->query('SELECT * FROM ' . $db->prefix('smiles') . ' WHERE display=1')) {
                while (false !== ($smiles = $db->fetchArray($result))) {
                    $ret .= "<img onclick='xoopsCodeSmilie(\"" . $this->getName() . '", " ' . $smiles['code'] . " \");' onmouseover='style.cursor=\"hand\"' src='" . XOOPS_UPLOAD_URL . '/' . htmlspecialchars($smiles['smile_url'], ENT_QUOTES) . "' alt=''>";
                }
            }
        } else {
            $count = count($smiles);
            for ($i = 0; $i < $count; $i++) {
                if (1 == $smiles[$i]['display']) {
                    $ret .= "<img onclick='xoopsCodeSmilie(\"" . $this->getName() . '", " ' . $smiles[$i]['code'] . " \");' onmouseover='style.cursor=\"hand\"' src='" . XOOPS_UPLOAD_URL . '/' . $myts->oopsHtmlSpecialChars($smiles['smile_url']) . "' border='0' alt=''>";
                }
            }
        }
        $ret .= "&nbsp;[<a href='#moresmiley' onclick='javascript:openWithSelfMain(\"" . XOOPS_URL . '/misc.php?action=showpopups&amp;type=smilies&amp;target=' . $this->getName() . "\",\"smilies\",300,475);'>" . _MORE . '</a>]';
        return $ret;
    }

    /**
     * prepare HTML for output of the Color Box.
     *
     * @return    string HTML
     * taken and modified from discuss module
     */
    public function _renderColor_Box()
    {
        $colors       = Utility::getAllowedColors();
        $color_box    = '<div id="color_box">';
        $color_used   = Utility::getLastColor();
        $checkedcolor = in_array($color_used, $colors);
        for ($i = 0; $i < count($colors); $i++) {
            $j         = $i + 1;
            $checked   = (($checkedcolor && ($colors[$i] == $color_used)) || (!$checkedcolor && (0 == $i))) ? ' checked' : '';
            $color_box .= '	<input id="color' . $j . '" name="color" value="' . $colors[$i] . '" type="radio"' . $checked . '>
	<span style="padding: 0; color: #' . $colors[$i] . ';">&#9632;</span>';
        }
        $color_box .= '</div>';
        return $color_box;
    }

    /**
     * prepare HTML for output of the Uname input.
     *
     * @return    string HTML
     */
    public function _renderUname_Input()
    {
        global $xoopsUser;
        $ret = '';
        if (!is_object($xoopsUser) && 1 == Utility::getModuleOptions('nick4guests')) {
            $ret = '<input type="text" name="achat_uname" id="achat_uname" size="6" maxlength="15" value="' . rtrim(_USERNAME, ' :&nbsp;') . '"><br>';
        }
        return $ret;
    }
}
