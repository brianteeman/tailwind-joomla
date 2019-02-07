<?php

use Joomla\CMS\Language\Text;
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>
<div class="w-full max-w-xs">
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="py-4 mb-4">
		<?php if ($params->get('pretext')) : ?>
			<div class="pretext">
				<p><?php echo $params->get('pretext'); ?></p>
			</div>
		<?php endif; ?>
		<div class="mb-4">
	      <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
	        <?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?>
	      </label>
	      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="username" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?>">
	    </div>
	    <div class="mb-4">
	      <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
	        <?php echo JText::_('JGLOBAL_PASSWORD'); ?>
	      </label>
	      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>">
	    </div>
		<div class="userdata">
			<?php if (count($twofactormethods) > 1) : ?>
				<div class="mb-4">
					<label class="block text-grey-darker text-sm font-bold mb-2" for="secretkey">
						<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>
					</label>
					<input type="text" name="secretkey" id="secretkey" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" value="" size="25" aria-invalid="false">
				</div>
			<?php endif; ?>
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
				<div class="mb-6">
					<label class="block text-grey-darker text-sm font-bold mb-2">
						<input id="remember" type="checkbox" name="remember" class="mr-2 leading-tight" />
						<span class="text-sm">
							<?php echo Text::_('MOD_LOGIN_REMEMBER_ME'); ?>
						</span>
					</label>
				</div>
			<?php endif; ?>
			<button class="bg-blue hover:bg-blue-dark text-white font-bold mb-4 py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
				<?php echo Text::_('JLOGIN'); ?>
			</button>
			<?php
				$usersConfig = JComponentHelper::getParams('com_users'); ?>
				<ul class="unstyled">
				<?php if ($usersConfig->get('allowUserRegistration')) : ?>
					<li>
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
						<?php echo JText::_('MOD_LOGIN_REGISTER'); ?> <span class="icon-arrow-right"></span></a>
					</li>
				<?php endif; ?>
					<li>
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
						<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
					</li>
					<li>
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
						<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
					</li>
				</ul>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.login" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
		<?php if ($params->get('posttext')) : ?>
			<div class="posttext">
				<p><?php echo $params->get('posttext'); ?></p>
			</div>
		<?php endif; ?>
	</form>
</div>