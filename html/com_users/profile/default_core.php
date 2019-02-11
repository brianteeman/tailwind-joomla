<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

?>
<fieldset id="users-profile-core">
  <div class="mb-4">
    <p class="text-xl leading-tight"><?php echo $this->escape($this->data->name); ?></p>
    <p class="text-sm leading-tight text-grey-dark"><?php echo $this->escape($this->data->username); ?></p>
  </div>
  <dl>
    <dt class="text-grey-darker mr-2"><?php echo Text::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?></dt>
    <dd class="text-black mb-4"><?php echo HTMLHelper::_('date', $this->data->registerDate, Text::_('DATE_FORMAT_LC1')); ?></dd>
    <dl class="text-grey-darker mr-2"><?php echo Text::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?></dl>
	<?php if ($this->data->lastvisitDate != $this->db->getNullDate()) : ?>
		<dd class="text-black mb-4"><?php echo HTMLHelper::_('date', $this->data->registerDate, Text::_('DATE_FORMAT_LC1')); ?></dd>
	<?php else: ?>
		<dd class="text-black mb-4"><?php echo JText::_('COM_USERS_PROFILE_NEVER_VISITED'); ?></dd>
	<?php endif; ?>
  </dl>
</fieldset>
