<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Component\ComponentHelper;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Create some shortcuts.
$params     = &$this->item->params;
$n          = count($this->items);
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$langFilter = false;

// Tags filtering based on language filter
if (($this->params->get('filter_field') === 'tag') && (Multilanguage::isEnabled()))
{
	$tagfilter = ComponentHelper::getParams('com_tags')->get('tag_list_language_filter');

	switch ($tagfilter)
	{
		case 'current_language' :
			$langFilter = Factory::getApplication()->getLanguage()->getTag();
			break;

		case 'all' :
			$langFilter = false;
			break;

		default :
			$langFilter = $tagfilter;
	}
}

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items))
{
	foreach ($this->items as $article)
	{
		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}
}

// For B/C we also add the css classes inline. This will be removed in 4.0.
Factory::getDocument()->addStyleDeclaration('
.hide { display: none; }
.table-noheader { border-collapse: collapse; }
.table-noheader thead { display: none; }
');

$tableClass = $this->params->get('show_headings') != 1 ? ' table-noheader' : '';
?>
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
<?php if ($this->params->get('filter_field') !== 'hide' || $this->params->get('show_pagination_limit')) : ?>
	<fieldset class="filters btn-toolbar clearfix">
		<legend class="hide"><?php echo Text::_('COM_CONTENT_FORM_FILTER_LEGEND'); ?></legend>
		<?php if ($this->params->get('filter_field') !== 'hide') : ?>
			<div class="mb-6 clearfix">
				<?php if ($this->params->get('filter_field') === 'tag') : ?>
						<div class="relative">
							<select name="filter_tag" id="filter_tag" onchange="document.adminForm.submit();" class="block appearance-none w-full bg-white shadow border border-grey-light text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey">
								<option value=""><?php echo Text::_('JOPTION_SELECT_TAG'); ?></option>
								<?php echo JHtml::_('select.options', JHtml::_('tag.options', array('filter.published' => array(1), 'filter.language' => $langFilter), true), 'value', 'text', $this->state->get('filter.tag')); ?>
							</select>
							<div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
					          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
					        </div>
					    </div>
				<?php elseif ($this->params->get('filter_field') === 'month') : ?>
						<div class="relative">
							<select name="filter-search" id="filter-search" onchange="document.adminForm.submit();" class="block appearance-none w-full bg-white shadow border border-grey-light text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey">
								<option value=""><?php echo Text::_('JOPTION_SELECT_MONTH'); ?></option>
								<?php echo JHtml::_('select.options', JHtml::_('content.months', $this->state), 'value', 'text', $this->state->get('list.filter')); ?>
							</select>
							<div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
					          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
					        </div>
					    </div>
				<?php else : ?>
					<div class="md:flex">
						<label class="md:w-1/2 filter-search-lbl element-invisible whitespace-no-wrap p-3 text-right" for="filter-search">
							<?php echo Text::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '&#160;'; ?>
						</label>
						<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="md:w-1/2 shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" onchange="document.adminForm.submit();" title="<?php echo Text::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo Text::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'); ?>" />
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="md:flex md:float-right">
				<label for="limit" class="element-invisible md:w-1/2 p-3 whitespace-no-wrap">
					<?php echo Text::_('JGLOBAL_DISPLAY_NUM'); ?>
				</label>
				<div class="relative md:w-1/2">
					<?php
						echo LayoutHelper::render(
							'tailwind.pagination.limitbox',
							[
								'pagination' => $this->pagination
							]
						);
					?>
					<div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
			          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
			        </div>
				</div>
			</div>
		<?php endif; ?>

		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
		<input type="hidden" name="task" value="" />
	</fieldset>
<?php endif; ?>

<?php if (empty($this->items)) : ?>
	<?php if ($this->params->get('show_no_articles', 1)) : ?>
		<p><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>
<?php else : ?>
	<table class="my-6 category text-left w-full <?php echo $tableClass; ?>">
		<caption class="hide"><?php echo Text::sprintf('COM_CONTENT_CATEGORY_LIST_TABLE_CAPTION', $this->category->title); ?></caption>
		<thead class="border-b border-grey-light">
			<tr class="mb-4">
				<th scope="col" class="p-3" id="categorylist_header_title">
					<?php
						echo LayoutHelper::render(
							'tailwind.grid.sort',
							[
								'order'     => 'a.title',
								'title'     => Text::_('JGLOBAL_TITLE'),
								'direction' => $listDirn,
								'selected'  => $listOrder
							]
						);
					?>
				</th>
				<?php if ($date = $this->params->get('list_show_date')) : ?>
					<th scope="col" class="p-3" id="categorylist_header_date">
						<?php
							$order = $date === 'created' ? 'a.created' : ($date === 'modified' ? 'a.modified' : 'a.publish_up');
							echo LayoutHelper::render(
								'tailwind.grid.sort',
								[
									'order'     => $order,
									'title'     => Text::_('COM_CONTENT_' . $date . '_DATE'),
									'direction' => $listDirn,
									'selected'  => $listOrder
								]
							);
						?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_author')) : ?>
					<th scope="col" class="p-3" id="categorylist_header_author">
						<?php
							echo LayoutHelper::render(
								'tailwind.grid.sort',
								[
									'order'     => 'author',
									'title'     => Text::_('JAUTHOR'),
									'direction' => $listDirn,
									'selected'  => $listOrder
								]
							);
						?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_hits')) : ?>
					<th scope="col" class="p-3" id="categorylist_header_hits">
						<?php
							echo LayoutHelper::render(
								'tailwind.grid.sort',
								[
									'order'     => 'a.hits',
									'title'     => Text::_('JGLOBAL_HITS'),
									'direction' => $listDirn,
									'selected'  => $listOrder
								]
							);
						?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_votes', 0) && $this->vote) : ?>
					<th scope="col" class="p-3" id="categorylist_header_votes">
						<?php echo JHtml::_('grid.sort', 'COM_CONTENT_VOTES', 'rating_count', $listDirn, $listOrder); ?>
					</th>
				<?php endif; ?>
				<?php if ($this->params->get('list_show_ratings', 0) && $this->vote) : ?>
					<th scope="col" class="p-3" id="categorylist_header_ratings">
						<?php echo JHtml::_('grid.sort', 'COM_CONTENT_RATINGS', 'rating', $listDirn, $listOrder); ?>
					</th>
				<?php endif; ?>
				<?php if ($isEditable) : ?>
					<th scope="col" class="p-3" id="categorylist_header_edit"><?php echo Text::_('COM_CONTENT_EDIT_ITEM'); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($this->items as $i => $article) : ?>
			<?php if ($this->items[$i]->state == 0) : ?>
				<tr class="mb-4 system-unpublished cat-list-row<?php echo $i % 2; ?>">
			<?php else : ?>
				<tr class="mb-4 cat-list-row<?php echo $i % 2; ?>" >
			<?php endif; ?>
			<td headers="categorylist_header_title" class="p-3 list-title border-b border-grey-light">
				<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
					<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)); ?>">
						<?php echo $this->escape($article->title); ?>
					</a>
					<?php if (JLanguageAssociations::isEnabled() && $this->params->get('show_associations')) : ?>
						<?php $associations = ContentHelperAssociation::displayAssociations($article->id); ?>
						<?php foreach ($associations as $association) : ?>
							<?php if ($this->params->get('flags', 1) && $association['language']->image) : ?>
								<?php $flag = JHtml::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true); ?>
								&nbsp;<a href="<?php echo JRoute::_($association['item']); ?>"><?php echo $flag; ?></a>&nbsp;
							<?php else : ?>
								<?php $class = 'label label-association label-' . $association['language']->sef; ?>
								&nbsp;<a class="<?php echo $class; ?>" href="<?php echo JRoute::_($association['item']); ?>"><?php echo strtoupper($association['language']->sef); ?></a>&nbsp;
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php else : ?>
					<?php
					echo $this->escape($article->title) . ' : ';
					$menu   = Factory::getApplication()->getMenu();
					$active = $menu->getActive();
					$itemId = $active->id;
					$link   = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
					$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)));
					?>
					<a href="<?php echo $link; ?>" class="register">
						<?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
					</a>
					<?php if (JLanguageAssociations::isEnabled() && $this->params->get('show_associations')) : ?>
						<?php $associations = ContentHelperAssociation::displayAssociations($article->id); ?>
						<?php foreach ($associations as $association) : ?>
							<?php if ($this->params->get('flags', 1)) : ?>
								<?php $flag = JHtml::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true); ?>
								&nbsp;<a href="<?php echo JRoute::_($association['item']); ?>"><?php echo $flag; ?></a>&nbsp;
							<?php else : ?>
								<?php $class = 'label label-association label-' . $association['language']->sef; ?>
								&nbsp;<a class="' . <?php echo $class; ?> . '" href="<?php echo JRoute::_($association['item']); ?>"><?php echo strtoupper($association['language']->sef); ?></a>&nbsp;
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($article->state == 0) : ?>
					<span class="list-published label label-warning">
								<?php echo Text::_('JUNPUBLISHED'); ?>
							</span>
				<?php endif; ?>
				<?php if (strtotime($article->publish_up) > strtotime(Factory::getDate())) : ?>
					<span class="list-published label label-warning">
								<?php echo Text::_('JNOTPUBLISHEDYET'); ?>
							</span>
				<?php endif; ?>
				<?php if ((strtotime($article->publish_down) < strtotime(Factory::getDate())) && $article->publish_down != Factory::getDbo()->getNullDate()) : ?>
					<span class="list-published label label-warning">
								<?php echo Text::_('JEXPIRED'); ?>
							</span>
				<?php endif; ?>
			</td>
			<?php if ($this->params->get('list_show_date')) : ?>
				<td headers="categorylist_header_date" class="p-3 list-title border-b border-grey-light list-date small">
					<?php
					echo JHtml::_(
						'date', $article->displayDate,
						$this->escape($this->params->get('date_format', Text::_('DATE_FORMAT_LC3')))
					); ?>
				</td>
			<?php endif; ?>
			<?php if ($this->params->get('list_show_author', 1)) : ?>
				<td headers="categorylist_header_author" class="p-3 list-title border-b border-grey-light list-author">
					<?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>
						<?php $author = $article->author ?>
						<?php $author = $article->created_by_alias ?: $author; ?>
						<?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) : ?>
							<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $article->contact_link, $author)); ?>
						<?php else : ?>
							<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
						<?php endif; ?>
					<?php endif; ?>
				</td>
			<?php endif; ?>
			<?php if ($this->params->get('list_show_hits', 1)) : ?>
				<td headers="categorylist_header_hits" class="p-3 list-title border-b border-grey-light list-hits">
							<span class="badge badge-info">
								<?php echo Text::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
							</span>
						</td>
			<?php endif; ?>
			<?php if ($this->params->get('list_show_votes', 0) && $this->vote) : ?>
				<td headers="categorylist_header_votes" class="p-3 list-title border-b border-grey-light list-votes">
					<span class="badge badge-success">
						<?php echo Text::sprintf('COM_CONTENT_VOTES_COUNT', $article->rating_count); ?>
					</span>
				</td>
			<?php endif; ?>
			<?php if ($this->params->get('list_show_ratings', 0) && $this->vote) : ?>
				<td headers="categorylist_header_ratings" class="p-3 list-title border-b border-grey-light list-ratings">
					<span class="badge badge-warning">
						<?php echo Text::sprintf('COM_CONTENT_RATINGS_COUNT', $article->rating); ?>
					</span>
				</td>
			<?php endif; ?>
			<?php if ($isEditable) : ?>
				<td headers="categorylist_header_edit" class="p-3 list-title border-b border-grey-light list-edit">
					<?php if ($article->params->get('access-edit')) : ?>
						<?php echo JHtml::_('icon.edit', $article, $params); ?>
					<?php endif; ?>
				</td>
			<?php endif; ?>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<?php // Code to add a link to submit an article. ?>
<?php if ($this->category->getParams()->get('access-create')) : ?>
	<?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?>
<?php endif; ?>

<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
	<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
		<div class="pagination">

			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>

			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
</form>
