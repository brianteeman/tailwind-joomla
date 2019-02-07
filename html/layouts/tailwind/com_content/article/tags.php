<?php
/**
 * @package     Phproberto.Template
 * @subpackage  Tailwind
 *
 * @copyright   Copyright (C) 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');

extract($displayData);
?>
<?php if (!empty($article->tags->itemTags)) : ?>
	<?php foreach ($article->tags->itemTags as $i => $tag) : ?>
		<?php $link = Route::_(TagsHelperRoute::getTagRoute($tag->tag_id . ':' . $tag->alias));; ?>
		<a href="<?php echo $link ?>" class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">
			#<?php echo $this->escape($tag->title); ?>
		</a>
	<?php endforeach; ?>
<?php endif;