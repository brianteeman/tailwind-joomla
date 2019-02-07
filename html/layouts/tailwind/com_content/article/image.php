<?php
/**
 * @package     Phproberto.Template
 * @subpackage  Tailwind
 *
 * @copyright   Copyright (C) 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Layout variables
 *
 * @var  stdClass   $article  Article as it comes from joomla models/helpers
 */
extract($displayData);

$options = empty($options) ? new Registry : new Registry($options);

$images = json_decode($article->images);

// Intro image available
if (!empty($images->image_intro))
{
	$imageUrl = $images->image_intro;
	$imageAlt = $images->image_intro_alt;
}
// Full text image available
elseif (!empty($images->image_fulltext))
{
	$imageUrl = $images->image_fulltext;
	$imageAlt = $images->image_fulltext_alt;
}
// Nothing to display
else
{
	$imageUrl = 'http://lorempixel.com/600/200/technics';
	$imageAlt = 'Header image';
}
?>
<img class="<?php echo $options->get('class'); ?>" src="<?php echo $imageUrl; ?>" alt="<?php echo $imageAlt; ?>" />