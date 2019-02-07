<?php
/**
 * @package		 Joomla.Site
 * @subpackage	com_users
 *
 * @copyright	 Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license		 GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

$usersConfig = ComponentHelper::getParams('com_users');

$showImage = $this->params->get('login_image') != '';
$showDescription = $this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '';
?>
<div class="mb-2 w-full max-w-sm mx-auto">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<h1 class="text-grey-dark text-center">
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	<?php endif; ?>
</div>
<div class="border border-grey-light bg-white rounded p-6 w-full max-w-sm mx-auto login<?php echo $this->pageclass_sfx; ?>">
	<?php if ($showImage) : ?>
		<div class="text-center mb-4">
			<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JText::_('COM_USERS_LOGIN_IMAGE_ALT'); ?>" />
		</div>
	<?php endif; ?>
	<?php if ($showDescription) : ?>
		<p class="text-center text-grey text-xs mb-4">
		 <?php echo $this->params->get('login_description'); ?>
		</p>
	<?php endif; ?>
	<form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate form-horizontal well mb-4">
		<div class="mb-4">
			<label class="block text-grey-darker text-sm font-bold mb-2" for="username">
				<?php echo Text::_('COM_USERS_LOGIN_USERNAME_LABEL'); ?>
			</label>
			<input type="text" name="username" id="username" value="" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline validate-username required invalid" size="25" required="required" aria-required="true" autofocus="" aria-invalid="true">
		</div>
		<div class="mb-4">
			<label class="block text-grey-darker text-sm font-bold mb-2" for="password">
				<?php echo Text::_('JGLOBAL_PASSWORD'); ?>
			</label>
			<input type="password" name="password" id="password" value="" class="validate-password required shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline" size="25" maxlength="99" required="required" aria-required="true" >
		</div>
		<?php if ($this->tfa) : ?>
			<div class="mb-4">
				<label class="block text-grey-darker text-sm font-bold mb-2" for="secretkey">
					<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>
				</label>
				<input type="text" name="secretkey" id="secretkey" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" value="" size="25" aria-invalid="false">
			</div>
		<?php endif; ?>
		<?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="mb-6">
				<label class="block text-grey-darker text-sm font-bold mb-2">
					<input id="remember" type="checkbox" name="remember" class="mr-2 leading-tight" />
					<span class="text-sm">
						<?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME'); ?>
					</span>
				</label>
			</div>
		<?php endif; ?>
		<div class="flex items-center justify-between">
			<button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
				<?php echo Text::_('JLOGIN'); ?>
			</button>
			<div>
				<?php if ($usersConfig->get('allowUserRegistration')) : ?>
					<a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>" class="block align-baseline font-bold text-sm text-blue hover:text-blue-darker">
						<?php echo Text::_('COM_USERS_LOGIN_REGISTER'); ?>
					</a>
				<?php endif; ?>
				<a class="block align-baseline font-bold text-sm text-blue hover:text-blue-darker" href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
					<?php echo Text::_('COM_USERS_LOGIN_RESET'); ?>
				</a>
				<a class="block align-baseline font-bold text-sm text-blue hover:text-blue-darker" href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
					<?php echo Text::_('COM_USERS_LOGIN_REMIND'); ?>
				</a>
			</div>
		</div>
		<?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
		<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
		<?php echo HTMLHelper::_('form.token'); ?>
	</form>
</div>
