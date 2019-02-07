<?php
/**
 * @package     Phproberto.Template
 * @subpackage  Tailwind
 *
 * @copyright   Copyright (C) 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

include_once dirname(__FILE__) . '/bootstrap.php';

$showRightColumn = ($this->countModules('position-3') || $this->countModules('position-6') || $this->countModules('position-8'));
$showBottom      = ($this->countModules('position-9') || $this->countModules('position-10') || $this->countModules('position-11'));
$showLeftColumn  = ($this->countModules('position-4') || $this->countModules('position-7') || $this->countModules('position-5'));

$showNoColumns = false === $showRightColumn && false === $showLeftColumn;
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
	<head>
		<meta charset="<?php echo $this->_charset; ?>">

		<!-- include joomla generated head  -->
		<jdoc:include type="head" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="<?=$this->baseurl?>/templates/<?=$this->template?>/assets/img/icons/favicon.ico">

		<link href="https://fonts.googleapis.com/css?family=Bree+Serif|Open+Sans" rel="stylesheet">
		<link rel="stylesheet" href="<?=$this->baseurl?>/templates/<?=$this->template?>/assets/css/template.min.css">

		<script src="<?=$this->baseurl?>/templates/<?=$this->template?>/assets/js/scripts.js"></script>
	</head>
	<body <?php if ($itemId): ?> id="item<?php echo $itemId; ?>" <?php endif; ?> class="bg-white font-source-sans font-normal text-black leading-normal <?=$bodyclass?>">
    <!-- Menu -->
    <?php if ($this->countModules('position-1')): ?>
      <div id="menu">
        <jdoc:include type="modules" name="position-1" style="standard"/>
      </div>
    <?php endif; ?>
    <div class="w-full max-w-3xl mx-auto px-6">
      <div class="lg:flex -mx-6">
        <?php if ($this->countModules('position-8')): ?>
          <aside id="sidebar" class="hidden absolute z-90 top-16 bg-white w-full border-b -mb-16 lg:-mb-0 lg:static lg:bg-transparent lg:border-b-0 lg:pt-0 lg:w-1/4 lg:block lg:border-0 xl:w-1/5">
            <div class="lg:block lg:relative lg:sticky lg:top-16">
              <div id="position-8" class="px-6 pt-6 overflow-y-auto text-base lg:text-sm lg:py-12 lg:pl-6 lg:pr-8 sticky?lg:h-(screen-16)">
                <jdoc:include type="modules" name="position-8" style="sidebarMenu" />
              </div>
            </div>
          </aside>
        <?php endif; ?>
        <div id="content-wrapper" class="min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible lg:w-3/4 xl:w-4/5">
          <div id="content">
            <div class="pt-12 px-6 pb-8 lg:pt-28 w-full">
              <jdoc:include type="message" />
              <jdoc:include type="component" />
            </div>
          </div>
        </div>
        <?php if ($this->countModules('position-7')) : ?>
            <aside id="right" class=" absolute z-90 top-16 w-full border-b -mb-16 lg:-mb-0 lg:static lg:bg-transparent lg:border-b-0 lg:pt-0 lg:w-1/4 lg:block lg:border-0 xl:w-1/5">
              <div class="lg:block lg:relative lg:sticky lg:top-16">
                <div id="position-8" class="px-6 pt-6 overflow-y-auto text-base lg:text-sm lg:py-12 lg:pl-6 lg:pr-8 sticky?lg:h-(screen-16)">
                  <jdoc:include type="modules" name="position-7" style="sidebarMenu" />
                </div>
              </div>
            </aside><!-- end right -->
        <?php endif ?>
      </div>
    </div>
      <div id="footer" class="bg-grey-lighter border-t border-grey-light py-6">
        <div class="w-full max-w-3xl mx-auto px-6">
          <button type="button" class="back-to-top float-right">Back to top</button>
          <p>&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?></p>
          <jdoc:include type="modules" name="footer" style="none" />
        </div>
      </div>
		<jdoc:include type="modules" name="debug" style="none" />
	</body>
</html>