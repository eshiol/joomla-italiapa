<?php
/**
 * @package		Template ItaliaPA
 * @subpackage	tpl_italiapa
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2017 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * Template ItaliaPA is free software. This version may have been modified
 * pursuant to the GNU General Public License, and as distributed it includes
 * or is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die;
JLog::add(new JLogEntry(__FILE__, JLog::DEBUG, 'tpl_italiapa'));

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls	= json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user	= JFactory::getUser();
$info	= $params->get('info_block_position', 0);

$params->set('info_block_style', 'inline');

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));
JHtml::_('behavior.caption');

if (JFactory::getApplication()->getTemplate(true)->params->get('debug') || defined('JDEBUG') && JDEBUG) : ?>
<div class="Prose Alert Alert--info Alert--withIcon u-padding-r-bottom u-padding-r-right u-margin-r-bottom">
see <a href="https://italia.github.io/design-web-toolkit/components/detail/page--default.html">
https://italia.github.io/design-web-toolkit/components/detail/page--default.html
</a>
</div>
<?php endif; ?>

<article class="Grid <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
	<div class="Grid-cell u-sizeFull<?php if ($params->get('access-view') && isset($images->image_fulltext) && !empty($images->image_fulltext)) echo ' u-md-size1of2 u-lg-size1of2'; ?> u-text-r-s u-padding-r-all">
		<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
		<?php
		if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
		{
			echo $this->item->pagination;
		}
		?>

		<?php // Todo Not that elegant would be nice to group the params ?>
		<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
		|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

		<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
			<?php echo JLayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
		<?php endif; ?>

		<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
		<?php echo $this->item->event->beforeDisplayContent; ?>

		<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position)))
			|| (empty($urls->urls_position) && (!$params->get('urls_position')))) : ?>
		<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>
		<?php if ($params->get('access-view')) : ?>
		<?php
		if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
			echo $this->item->pagination;
		endif;
		?>

		<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1 class="u-text-h1 u-margin-r-bottom">
		  	<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
		<?php endif; ?>

		<?php if (!$useDefList && $this->print) : ?>
			<div id="pop-print" class="btn hidden-print">
				<?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
			</div>
			<div class="clearfix"> </div>
		<?php endif; ?>
		<?php if (!$this->print) : ?>
			<?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
			<?php endif; ?>
		<?php else : ?>
			<?php if ($useDefList) : ?>
				<div id="pop-print" class="btn hidden-print">
					<?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<div class=" u-text-p">
			<?php if ($params->get('show_title') || $params->get('show_author')) : ?>
			<div class="page-header">
				<?php if ($params->get('show_title')) : ?>
					<h2 class="u-text-h2 u-margin-r-bottom" itemprop="headline">
						<?php echo $this->escape($this->item->title); ?>
					</h2>
				<?php endif; ?>
				<?php if ($this->item->state == 0) : ?>
					<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
				<?php endif; ?>
				<?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
					<span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
				<?php endif; ?>
				<?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate()) : ?>
					<span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
				<?php endif; ?>
			</div>
			<?php endif; ?>

		<?php //if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
		<?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
			<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>

			<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
		<?php endif; ?>

			<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
			<?php echo $this->item->event->afterDisplayTitle; ?>

			<?php if (isset($this->item->toc) && $this->item->toc) : ?>
			<div class="Grid">
				<div class="Grid-cell u-sizeFull u-md-size3of4 u-lg-size3of4 u-text-r-s u-padding-r-all">
			<?php endif; ?>
					<div class="u-textSecondary u-lineHeight-l" itemprop="articleBody">
						<?php echo $this->item->text; ?>
					</div>
			<?php if (isset($this->item->toc) && $this->item->toc) : ?>
					<?php echo $this->item->pagenavcounter; ?>
				</div>

				<aside class="Grid-cell u-sizeFull u-md-size1of4 u-lg-size1of4 u-text-r-s u-padding-r-all">
					<?php echo $this->item->toc; ?>
				</aside>
			</div>
			<?php endif; ?>

		</div>

		<?php if ($info == 1 || $info == 2) : ?>
			<?php if ($useDefList) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
			<?php endif; ?>

			<?php //if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
				<?php //$this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
				<?php //echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
			<?php //endif; ?>
		<?php endif; ?>

		<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
		<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>
		<?php // Optional teaser intro text for guests ?>
		<?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
		<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
		<?php echo JHtml::_('content.prepare', $this->item->introtext); ?>
		<?php // Optional link to let them register to see the whole article. ?>
		<?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
		<?php $menu = JFactory::getApplication()->getMenu(); ?>
		<?php $active = $menu->getActive(); ?>
		<?php $itemId = $active->id; ?>
		<?php $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
		<?php $link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language))); ?>
		<p class="readmore">
			<a href="<?php echo $link; ?>" class="register">
			<?php $attribs = json_decode($this->item->attribs); ?>
			<?php
			if ($attribs->alternative_readmore == null) :
				echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
			elseif ($readmore = $attribs->alternative_readmore) :
				echo $readmore;
				if ($params->get('show_readmore_title', 0) != 0) :
					echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
				endif;
			elseif ($params->get('show_readmore_title', 0) == 0) :
				echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
			else :
				echo JText::_('COM_CONTENT_READ_MORE');
				echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
			endif; ?>
			</a>
		</p>
		<?php endif; ?>
		<?php endif; ?>
	</div>

	<?php if ($params->get('access-view') && isset($images->image_fulltext) && !empty($images->image_fulltext)) : ?>
	<div class="Grid-cell u-sizeFull u-md-size1of2 u-lg-size1of2 u-text-r-s u-padding-r-all">
		<?php echo JLayoutHelper::render('joomla.content.full_image', $this->item); ?>
	</div>
	<?php endif; ?>

	<?php $app = JFactory::getApplication(); ?>
	<?php $tpl = $app->getTemplate(true); ?>
	<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
		<?php if ($logo = $tpl->params->get('logo')) : ?>
		<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
			<meta itemprop="url" content="<?php echo JUri::base().$logo; ?>">
		</span>
		<?php endif; ?>
 		<meta itemprop="name" content="<?php echo htmlspecialchars($app->get('sitename')); ?>">
	</span>

	<?php
	// Content is generated by content plugin event "onContentAfterDisplay"
	echo $this->item->event->afterDisplayContent;
	?>
</article>

		<?php
		if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative) :
			echo $this->item->pagination;
		endif;
		?>