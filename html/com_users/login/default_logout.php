<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$showImage = $this->params->get('logout_image') != '';
$showDescription = $this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description')) != '';
?>
<div class="mb-2 w-full max-w-sm mx-auto">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<h1 class="text-grey-dark text-center">
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	<?php endif; ?>
</div>
<div class="border border-grey-light bg-white rounded p-6 w-full max-w-sm mx-auto logout<?php echo $this->pageclass_sfx; ?>">
	<?php if ($showImage) : ?>
		<div class="text-center mb-4">
			<img src="<?php echo $this->escape($this->params->get('logout_image')); ?>" class="thumbnail pull-right logout-image" alt="<?php echo JText::_('COM_USER_LOGOUT_IMAGE_ALT'); ?>" />
		</div>
	<?php endif; ?>
	<?php if ($showDescription) : ?>
		<div class="text-center text-grey text-xs mb-4 logout-description">
			<?php echo $this->params->get('logout_description'); ?>
		</div>
	<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post" class="form-horizontal well">
		<button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
			<?php echo JText::_('JLOGOUT'); ?>
		</button>
		<?php if ($this->params->get('logout_redirect_url')) : ?>
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return'))); ?>" />
		<?php else : ?>
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_menuitem', $this->form->getValue('return'))); ?>" />
		<?php endif; ?>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
