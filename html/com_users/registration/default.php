<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

?>
<div class="w-full registration<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		</div>
	<?php endif; ?>
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
		<?php // Iterate through the form fieldsets and display each one. ?>
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<?php if (count($fields)) : ?>
				<fieldset>
					<?php // If the fieldset has a label set, display it as the legend. ?>
					<?php if (isset($fieldset->label)) : ?>
						<h2 class="mb-4"><?php echo JText::_($fieldset->label); ?></h2>
					<?php endif; ?>
					<?php foreach ($fields as $field) : ?>
						<?php
						if ('Spacer' === $field->type)
						{
							continue;
						}
						?>
						<?php
						$field->hint = $field->description;
						$field->description = '';
						$field->labelclass = 'block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2';
						$field->class = 'appearance-none block w-full bg-grey-lighter text-grey-darker border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white';
						?>
						<?php echo $field->renderField(); ?>
					<?php endforeach; ?>
					<?php //echo $this->form->renderFieldset($fieldset->name); ?>
				</fieldset>
			<?php endif; ?>
		<?php endforeach; ?>
		<div class="mt-4">
			<button class="bg-blue hover:bg-blue-dark text-white mr-6 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline validate" type="submit">
				<?php echo JText::_('JREGISTER'); ?>
			</button>
			<a href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>">
				<?php echo JText::_('JCANCEL'); ?>
			</a>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
