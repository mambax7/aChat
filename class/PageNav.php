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

xoops_load('XoopsPageNav');

/**
 * Class to facilitate navigation in a multi page document/list
 *
 * @package     discuss
 */
class PageNav extends \XoopsPageNav
{
    /**
     * @access  private
     */
    // addition
    public $_order;
    public $_extra;
    public $_perpage_arr = [15, 30, 50, 100, 200, 500, 1000];
    /**
     * Constructor
     *
     * @param int    $total_items   Total number of items
     * @param int    $items_perpage Number of items per page
     * @param int    $current_start First item on the current page
     * @param string $extra_arg     Additional arguments to pass in the URL
     * @param mixed  $order
     **/
    // Modifié
    public function __construct($total_items, $items_perpage, $current_start, $order = 'DESC', $extra_arg = '')
    {
        parent::__construct($total_items, $items_perpage, $current_start, 'start', 'perpage=' . (int)$items_perpage . '&amp;order=' . $order . '&amp;' . $extra_arg);
        // Ajout et Modif
        $this->_order = $order;
        $this->_extra = $extra_arg;
    }

    /**
     * Set perpage array
     *
     * @param array $perpages
     **/
    public function setPerpageArray($perpages)
    {
        $this->_perpage_arr = $perpages;
    }

    /**
     * Create navigation
     *
     * @param int $offset
     * @return  string
     **/
    public function renderAuto($offset = 4)
    {
        if (!$this->perpage) {
            return '';
        }
        $ret         = $this->renderNav($offset);
        $total_pages = ceil($this->total / $this->perpage);
        if ('' != $ret && $total_pages <= $offset) {
            $extra_arg = $this->_extra;
            if ('' != $extra_arg && ('&amp;' != mb_substr($extra_arg, -5) || '&' != mb_substr($extra_arg, -1))) {
                $extra_arg .= '&amp;';
            }
            // Modifié
            $ret .= '&nbsp;<a href="' . xoops_getenv('PHP_SELF') . '?perpage=' . $this->total . '&amp;order=' . $this->_order . '&amp;' . $extra_arg . 'start=1">' . _ALL . '</a>';
        }
        if ($this->total > 0) {
            $ret .= $this->renderSelectStart($total_pages);
        }
        return $ret;
    }

    /**
     * Create a navigational dropdown list
     *
     * @param mixed $total_pages
     * @return  string
     **/
    public function renderSelectStart($total_pages)
    {
        $extra_arg = $this->_extra;
        if ('' != $extra_arg) {
            $extra_arg = preg_replace('/&amp;/', '&', $extra_arg);
            if ('&' != mb_substr($extra_arg, -1)) {
                $extra_arg .= '&';
            }
        }
        // Changed
        $ret = '<script type="text/javascript">
function navigate() {
	var order = "DESC";
	var objForm = xoopsGetElementById("pagenavform");
	if (objForm.order[0].checked) {
		order = "ASC";
	}
	document.location=\'' . xoops_getenv('PHP_SELF') . '?perpage=\' + objForm.perpage[objForm.perpage.selectedIndex].value + \'&' . $extra_arg . 'start=\' + objForm.start.options[objForm.start.options.selectedIndex].value + \'&order=\' + order;
}

function changeDisplaypagenavForm() {
	var objForm = xoopsGetElementById("pagenavform");
	var elestyle = objForm.style;
	if (elestyle.display == "" || elestyle.display == "block") {
		elestyle.display = "none";
	} else {
		elestyle.display = "block";
	}
}
</script>';
        // Ajout
        $ret .= '&nbsp;&nbsp;<a href="javascript:;" onclick="changeDisplaypagenavForm();">' . _OPTIONS . '</a>';
        $ret .= '<form name="pagenavform" action="#" style="display: none;" id="pagenavform">';
        // Ajouts
        $checked = ('ASC' == $this->_order) ? ' checked' : '';
        $ret     .= '<input name="order" value="ASC"' . $checked . ' type="radio">' . _MD_ACHAT_FIRST_OLD;
        $checked = ('DESC' == $this->_order) ? ' checked' : '';
        $ret     .= '<input name="order" value="DESC"' . $checked . ' type="radio">' . _MD_ACHAT_FIRST_RECENT;
        // Fin Ajouts
        $ret      .= '&nbsp;<select name="perpage">';
        $perpages = $this->_perpage_arr;
        if (!in_array($this->perpage, $perpages)) {
            array_unshift($perpages, $this->perpage);
        }
        foreach ($perpages as $perpage) {
            $selected = ($perpage == $this->perpage) ? '" selected="selected">' : '">';
            $ret      .= '<option value="' . $perpage . $selected . $perpage . ' ' . _MD_ACHAT_MESSAGES . '</option>';
        }
        $ret          .= '</select>';
        $ret          .= '<select name="start" onchange="navigate();">';
        $counter      = 1;
        $current_page = (int)floor(($this->current + $this->perpage) / $this->perpage);
        while ($counter <= $total_pages) {
            if ($counter == $current_page) {
                $ret .= '<option value="' . (($counter - 1) * $this->perpage) . '" selected="selected">' . _MD_ACHAT_FROM . ' ' . (($counter - 1) * $this->perpage + 1) . '</option>';
            } else {
                $ret .= '<option value="' . (($counter - 1) * $this->perpage) . '">' . _MD_ACHAT_FROM . ' ' . (($counter - 1) * $this->perpage + 1) . '</option>';
            }
            $counter++;
        }
        $ret .= '</select>';
        $ret .= '&nbsp;<input type="button" value="' . _GO . '" onClick="navigate();">';
        $ret .= '</form>';
        return $ret;
    }
}
