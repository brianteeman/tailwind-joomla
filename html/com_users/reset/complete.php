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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

?>
<div class="w-full reset-complete<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<h2 class="mb-4"><?php echo Text::_('TPL_TAILWIND_LBL_ENTER_NEW_PASSWORD'); ?></h2>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.complete'); ?>" method="post" class="form-validate form-horizontal well">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<fieldset>
				<?php if (isset($fieldset->label)) : ?>
					<p class="text-grey-darker mb-4"><?php echo JText::_($fieldset->label); ?></p>
				<?php endif; ?>
				<?php foreach ($fields as $field) : ?>
					<?php
					if ('Spacer' === $field->type)
					{
						continue;
					}
					?>
					<?php
					$field->description = '';
					$field->labelclass = 'block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2';
					$field->class = 'appearance-none block w-full bg-grey-lighter text-grey-darker border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white';
					?>
					<?php echo $field->renderField(); ?>
				<?php endforeach; ?>
			</fieldset>
		<?php endforeach; ?>
		<div class="mt-4">
			<button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline validate" type="submit">
				<?php echo JText::_('JSUBMIT'); ?>
			</button>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
