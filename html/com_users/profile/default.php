<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

?>
<div class="w-full profile<?php echo $this->pageclass_sfx; ?>">
	<?php if (Factory::getUser()->id == $this->data->id) : ?>
		<div class="md:float-right">
				<a class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="<?php echo Route::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id); ?>">
					<?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?>
				</a>
		</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<h2 class="mb-4"><?php echo Text::_('COM_USERS_PROFILE_CORE_LEGEND'); ?></h2>
	<?php echo $this->loadTemplate('core'); ?>
	<?php echo $this->loadTemplate('params'); ?>
	<?php echo $this->loadTemplate('custom'); ?>
</div>
