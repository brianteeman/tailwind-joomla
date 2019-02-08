<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Webete\App;

extract($displayData);

// Nothing to show
if (empty($messages))
{
	return;
}
?>
<div class="bg-red-lightest border-l-4 border-red text-red-dark p-4 relative mb-6" role="alert">
  <p class="font-bold"><?=$title?></p>
  <?php foreach ($messages as $message) : ?>
  	<p><?php echo $message; ?></p>
  <?php endforeach; ?>
  <button class="absolute pin-t pin-b pin-r px-4 py-3" data-dismiss="alert">
    <svg class="fill-current h-6 w-6 text-red-dark" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </button>
</div>
