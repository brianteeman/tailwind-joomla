<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = '';

if (($tagId = $params->get('tag_id', '')))
{
	$id = ' id="' . $tagId . '"';
}

$moduleClass = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');
?>
<nav>
	<ul>
		<?php foreach ($list as $i => &$item) : ?>
			<li class="mb-3 lg:mb-2">
				<?php
					$item->anchor_css = 'hover:underline text-grey-darkest item-' . $item->id . ' ' . $item->anchor_css;

					if ($item->id == $default_id)
					{
						$item->anchor_css .= ' default';
					}

					if (($item->id == $active_id) || ($item->type == 'alias' && $item->params->get('aliasoptions') == $active_id))
					{
						$item->anchor_css .= ' current';
					}

					if (in_array($item->id, $path))
					{
						$item->anchor_css .= ' active';
					}

					if ($item->deeper)
					{
						$item->anchor_css .= ' deeper';
					}

					if ($item->parent)
					{
						$item->anchor_css .= ' parent';
					}

					switch ($item->type) :
						case 'separator':
						case 'component':
						case 'heading':
						case 'url':
							require JModuleHelper::getLayoutPath('mod_menu', 'navbar_' . $item->type);
							break;

						default:
							require JModuleHelper::getLayoutPath('mod_menu', 'navbar_url');
							break;
					endswitch;
				?>
			</li>
		<?php endforeach; ?>


	</ul>
</nav>
