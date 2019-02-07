<?php
/**
 * @package	 Joomla.Site
 * @subpackage	com_content
 *
 * @copyright	 Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license	 GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info	= $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));

$link = Route::_(
	ContentHelperRoute::getArticleRoute(
		$this->item->slug, $this->item->catid, $this->item->language
	)
);

$categoryLink = Route::_(
		ContentHelperRoute::getCategoryRoute($this->item->catslug
	)
);

$showTags = $info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags);
?>
<div class="w-full mb-6">
	<div class="flex flex-col justify-between leading-normal">
		<?php echo LayoutHelper::render('tailwind.com_content.article.image', ['article' => $this->item, 'options' => ['class' => 'w-full']]); ?>
		<div class="mt-3">
			<div class="mb-2">
				<div class="text-black font-bold text-xl py-2 xs:float-left lg:float-none">
					<a class="text-grey-darkest hover:underline" href="<?php echo $link ?>" itemprop="url">
						<?php echo $this->escape($this->item->title); ?>
					</a>
				</div>
				<div class="flex items-center py-2 text-sm">
						<p class="text-grey-dark mr-2">
							<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY',''); ?>
						</p>
						<p class="text-black leading-none mr-4">
							<span itemprop="name"><?php echo ($this->item->created_by_alias ?: $article->author); ?></span>
						</p>
						<p class="text-grey-dark border-l border-grey-light pl-4 mr-2">
							<?php echo Text::sprintf('COM_CONTENT_CATEGORY', ''); ?>
						</p>
						<p class="text-black leading-none mr-4">
							<a href="<?php echo $categoryLink; ?>"><?php echo $this->escape($this->item->category_title) ?></a>
						</p>
						<p class="text-grey-dark border-l border-grey-light pl-4">
							<?php echo HTMLHelper::_('date', $this->item->created, Text::_('DATE_FORMAT_LC3')); ?>
						</p>
				</div>
				<div class="text-grey-darker text-base">
					<?php echo $this->item->introtext; ?>
					<?php echo $this->item->event->afterDisplayContent; ?>
				</div>
			</div>
			<?php if ($showTags) : ?>
				<div class="py-4">
					<div class="">
						<?php echo LayoutHelper::render('tailwind.com_content.article.tags', ['article' => $this->item]); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
