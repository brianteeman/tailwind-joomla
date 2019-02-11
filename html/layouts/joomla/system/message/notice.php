<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

extract($displayData);

// Nothing to show
if (empty($messages))
{
	return;
}

?>
<div class="bg-blue-lightest border-t-4 border-blue rounded-b text-blue-darkest px-4 py-3 shadow-md relative mb-6" role="alert">
  <div class="flex">
    <div class="py-1"><svg class="fill-current h-6 w-6 text-blue mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold"><?=$title?></p>
	  <?php foreach ($messages as $message) : ?>
	  	<p class="text-sm"><?php echo $message; ?></p>
	  <?php endforeach; ?>
    </div>
  </div>
  <button class="absolute pin-t pin-b pin-r px-4 py-3" data-dismiss="alert">
    <svg class="fill-current h-6 w-6 text-blue-dark" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </button>
</div>