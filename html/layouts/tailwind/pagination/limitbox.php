<?php
/**
 * @package     Phproberto.Template
 * @subpackage  Tailwind
 *
 * @copyright   Copyright (C) 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

extract($displayData);

$class = isset($class) ? $class : 'block appearance-none w-full bg-white shadow border border-grey-light text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey';

$selected = $pagination->limit;

$limits = [];

// Make the option list.
for ($i = 5; $i <= 30; $i += 5)
{
	$limits[] = HTMLHelper::_('select.option', "$i");
}

$limits[] = HTMLHelper::_('select.option', '50', Text::_('J50'));
$limits[] = HTMLHelper::_('select.option', '100', Text::_('J100'));
$limits[] = HTMLHelper::_('select.option', '0', Text::_('JALL'));

echo HTMLHelper::_(
	'select.genericlist',
	$limits,
	$pagination->prefix . 'limit',
	'class="' . $class  . '" size="1" onchange="Joomla.submitform();"',
	'value',
	'text',
	$selected
);