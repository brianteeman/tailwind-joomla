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
<nav class="flex items-center justify-between flex-wrap bg-teal p-6 <?php echo $moduleClass; ?> ">
	<div class="w-full max-w-3xl mx-auto px-6">
		<div class="flex items-center flex-no-shrink text-white mr-6">
			<svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
			<span class="font-semibold text-xl tracking-tight">Tailwind CSS</span>
		</div>
		<div class="block lg:hidden">
			<button class="navbar-burger flex items-center px-3 py-2 border rounded text-teal-lighter border-teal-light hover:text-white hover:border-white">
			<svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
			</button>
		</div>
		<div id="main-nav" class="w-full block flex-grow lg:flex lg:items-center lg:w-auto hidden <?php echo $class_sfx; ?>" <?php echo $id; ?>>
			<div class="text-sm lg:flex-grow">
				<?php foreach ($list as $i => &$item) : ?>
					<?php
						$item->anchor_css = 'block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4 item-' . $item->id . ' ' . $item->anchor_css;

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
				<?php endforeach; ?>
			</div>
		<div>
			<a href="#" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0">Download</a>
		</div>
	  </div>
	</div>
</nav>

