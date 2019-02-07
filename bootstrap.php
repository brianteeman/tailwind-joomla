<?php
/**
 * @package     Phproberto.Template
 * @subpackage  Tailwind
 *
 * @copyright   Copyright (C) 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

// Required objects
$app 	= Factory::getApplication();
$doc 	= Factory::getDocument();

$menu = $app->getMenu();

// Get URL parameters
$option = $app->input->get('option', '');
$view   = $app->input->get('view', '');
$layout = $app->input->get('layout', '');
$lang   = $app->input->get('lang', null);
$itemId = $app->input->getCmd('Itemid');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

// Determine the current language tag
$langTag = null;

if ($lang)
{
	$langTag = Factory::getLanguage()->getTag();
}

/**
 * ==================================================
 * Frontpage check
 * ==================================================
 */
$isFrontpage = $lang ? $menu->getActive() == $menu->getDefault($langTag) : $menu->getActive() == $menu->getDefault();

/**
 * Automatic body classes
 */

$bodyClasses = array($isFrontpage ? 'home' : 'sub');

if ($option)
{
	$optionParts = explode('_', $option);
	$bodyClasses[] = 'option-' . end($optionParts);
}

if ($view)
{
	$bodyClasses[] = 'view-' . $view;
}

if ($layout)
{
	$bodyClasses[] = 'layout-' . $layout;
}

if ($itemId)
{
	$bodyClasses[] = 'menuitem-id-' . $itemId;
}

if ($this->countModules('toolbar'))
{
	$bodyClasses[] = "toolbarpadding";
}

$bodyclass = trim(implode(' ', $bodyClasses));
