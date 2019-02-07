<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$positionLayouts = [
	'position-1' => 'navbar',
	'position-7' => 'sidebar',
	'position-8' => 'sidebar'
];

// We force navbar layout for modules assigned to position-1 to ease setup
if (property_exists($module, 'position') && isset($positionLayouts[$module->position]))
{
	require JModuleHelper::getLayoutPath('mod_menu', $positionLayouts[$module->position]);

	return;
}

include JPATH_SITE . '/modules/mod_menu/tmpl/default.php';
