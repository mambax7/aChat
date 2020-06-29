<?php

declare(strict_types=1);

namespace XoopsModules\Achat\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use XoopsObjectTree;

/**
 * Module: Achat
 *
 * @category        Module
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */
//xoops_load('XoopsObjectTree');
require_once XOOPS_ROOT_PATH . '/class/tree.php';

/**
 * Form element that ...
 */
class ObjectTree extends XoopsObjectTree
{
    /**
     * Make options for a select box from
     *
     * @param string       $fieldName    Name of the member variable from the node objects that should be used as the title for the options.
     * @param int          $key          ID of the object to display as the root of select options
     * @param string|array $optionsArray (reference to a string when called from outside) Result from previous recursions
     * @param string       $prefix_orig  String to indent items at deeper levels
     * @param string       $prefix_curr  String to indent the current item
     *
     * @return string
     * @access private
     */
    public function makeSelBoxOptionsArray($fieldName, $key, &$optionsArray, $prefix_orig, $prefix_curr = '')
    {
        if ($key > 0) {
            $value                = $this->tree[$key]['obj']->getVar($this->myId);
            $optionsArray[$value] = $prefix_curr . $this->tree[$key]['obj']->getVar($fieldName);
            $prefix_curr          .= $prefix_orig;
        }
        if (isset($this->tree[$key]['child']) && !empty($this->tree[$key]['child'])) {
            foreach ($this->tree[$key]['child'] as $childkey) {
                $this->makeSelBoxOptionsArray($fieldName, $childkey, $optionsArray, $prefix_orig, $prefix_curr);
            }
        }
        return $optionsArray;
    }

    /**
     * Make a select box with options from the tree
     *
     * @param string $name
     * @param string $fieldName       Name of the member variable from the node objects that should be used as the title for the options.
     * @param string $prefix          String to indent deeper levels
     * @param string $selected
     * @param bool   $addEmptyOption  Set TRUE to add an empty option with value "0" at the top of the hierarchy
     * @param int    $key             ID of the object to display as the root of select options
     *
     * @param string $extra
     * @return string|array $optionsArray   Associative array of value->name pairs, useful for <a href='psi_element://XoopsFormSelect'>XoopsFormSelect</a>->addOptionArray method
     *                                addOptionArray method
     */
    public function makeSelBox($name, $fieldName, $prefix = '-', $selected = '', $addEmptyOption = false, $key = 0, $extra = '')
        //    public function makeSelBox($fieldName, $prefix = '-', $addEmptyOption = false, $key = 0)
    {
        $optionsArray = [];
        if ($addEmptyOption) {
            $optionsArray[0] = '';
        }
        return $this->makeSelBoxOptionsArray($fieldName, $key, $optionsArray, $prefix);
    }
}
