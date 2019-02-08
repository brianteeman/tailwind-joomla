<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

extract($displayData);

$allowedTypes = [
	'error'       => 'error',
	'message'     => 'message',
	'notice'      => 'notice',
	'warning'     => 'warning'
];

?>
<div id="system-message-container">
	<div id="system-message">
		<?php
			foreach ($msgList as $type => $msgs)
			{
				$lang = \JFactory::getLanguage();

				$titleLangString = 'TPL_LICEO_LBL_ALERT_' . strtoupper($type) . '_TITLE';

				$type = array_key_exists($type, $allowedTypes) ? $allowedTypes[$type] : 'notice';

				$title = $lang->hasKey($titleLangString) ? JText::_($titleLangString) : JText::_($type);

				$layoutData = array(
					'title'    => $title,
					'type'     => $type,
					'messages' => $msgs
				);

				echo LayoutHelper::render('joomla.system.message.' . strtolower($type), $layoutData);
			}
		?>
	</div>
</div>
