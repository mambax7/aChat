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
/**
 * Module: Achat
 *
 * @category        Module
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

/*
* Example:
* $breadcrumb = new Common\Breadcrumb();
* $breadcrumb->addLink( 'bread 1', 'index1.php' );
* $breadcrumb->addLink( 'bread 2', '' );
* $breadcrumb->addLink( 'bread 3', 'index3.php' );
* echo $breadcrumb->render();
*/

use XoopsModules\Achat;
use XoopsModules\Achat\Common;

/**
 * Class Breadcrumb
 */
class Breadcrumb
{
    public  $dirname;
    private $bread = [];

    public function __construct()
    {
        $this->dirname = basename(dirname(dirname(__DIR__)));
    }

    /**
     * Add link to breadcrumb
     *
     * @param string $title
     * @param string $link
     */
    public function addLink($title = '', $link = '')
    {
        $this->bread[] = [
            'link'  => $link,
            'title' => $title,
        ];
    }

    /**
     * Render BreadCrumb
     */
    public function render()
    {
        /*
        TODO if you want to use the render code below,
        1) create ./templates/chess_common_breadcrumb.tpl)
        2) add declaration to  xoops_version.php
        */
        /*
        if (!isset($GLOBALS['xoTheme']) || !\is_object($GLOBALS['xoTheme'])) {
            require $GLOBALS['xoops']->path('class/theme.php');

            $GLOBALS['xoTheme'] = new \xos_opal_Theme();
        }

        require $GLOBALS['xoops']->path('class/template.php');

        $breadcrumbTpl = new \XoopsTpl();

        $breadcrumbTpl->assign('breadcrumb', $this->bread);

        $html = $breadcrumbTpl->fetch('db:' . $this->dirname . '_common_breadcrumb.tpl');

        unset($breadcrumbTpl);

        return $html;
        */
    }
}
