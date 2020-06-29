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
trait ModuleStats
{
    /**
     * @param \XoopsModules\Achat\Common\Configurator $configurator
     * @param array                                   $moduleStats
     * @return array
     */
    public static function getModuleStats($configurator, $moduleStats)
    {
        if (count($configurator->moduleStats) > 0) {
            foreach (array_keys($configurator->moduleStats) as $i) {
                $moduleStats[$i] = $configurator->moduleStats[$i];
            }
        }
        return $moduleStats;
    }
}
