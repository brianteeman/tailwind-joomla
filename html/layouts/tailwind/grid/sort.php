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
use Joomla\Registry\Registry;

/**
 * Layout variables
 *
 * @param   string  $title         The link title
 * @param   string  $order         The order field for the column
 * @param   string  $direction     The current direction
 * @param   string  $selected      The selected ordering
 * @param   string  $task          An optional task override
 * @param   string  $newDirection  An optional direction for the new column
 * @param   string  $tip           An optional text shown as tooltip title instead of $title
 * @param   string  $form          An optional form selector
 */
extract($displayData);

$form = isset($form) ? ", document.getElementById('" . $form . "')" : null;
$class = isset($class) ? $class : 'text-grey-darker';
$active = $order === $selected;
$newDirection = isset($newDirection) ? $newDirection : 'asc';
$direction = !$active ? $newDirection : ($direction === 'desc' ? 'asc' : 'desc');
?>
<a href="#" onclick="Joomla.tableOrdering('<?php echo $order; ?>', '<?php echo $direction; ?>'<?php echo $form; ?>);return false;" class="<?php echo $class; ?>">
	<?php echo $title; ?>
	<?php if ($active && $direction === 'desc') : ?>
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M10 11.002v2L18 13v-2l-8 .002zm0-6v2L14 7V5l-4 .002zM10 17v2.002h12V17H10zM6 7.002h2.5L5 3.502l-3.5 3.5H4V20h2V7.002z" fill="#626262"/></svg>
	<?php elseif ($active) : ?>
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M10 12.998v-2L18 11v2l-8-.002zm0 6v-2L14 17v2l-4-.002zM10 7V4.998h12V7H10zm-4 9.998h2.5l-3.5 3.5-3.5-3.5H4V4h2v12.998z" fill="#626262"/></svg>
	<?php endif; ?>
</a>