<?php
/**
 * @package		Joomla.Site
 * @subpackage	Templates.ItaliaPA
 *
 * @author		Helios Ciancio <info (at) eshiol (dot) it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2017 - 2020 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * Template ItaliaPA is free software. This version may have been modified
 * pursuant to the GNU General Public License, and as distributed it includes
 * or is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

?>
<?php foreach ($this->items[$this->parent->id] as $id => $item) : ?>
	<?php if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) : ?>
		<div class="Grid-cell u-md-size1of3 u-lg-size1of3 u-flex u-margin-r-bottom u-flexJustifyCenter" itemprop="blogPost" itemscope="" itemtype="https://schema.org/BlogPosting">
    		<div class="u-nbfc u-borderShadow-xxs u-borderRadius-m u-color-black u-background-white u-sizeFull">
    			<?php if ($item->getParams()->get('image')) : ?>
					<img src="<?php echo $item->getParams()->get('image'); ?>" class="u-sizeFull"/>
           		<?php endif; ?>
           		<div class="u-text-r-l u-padding-r-all u-layout-prose">
                    <h3 class="u-text-h4 u-margin-r-bottom" itemprop="headline">
    					<a href="<?php echo JRoute::_(NewsfeedsHelperRoute::getCategoryRoute($item->id, $item->language)); ?>"
    						class="u-text-r-m u-color-black u-textWeight-400 u-textClean">
    						<?php echo $this->escape($item->title); ?>
    					</a>
    				</h3>
    				<?php if ($this->params->get('show_subcat_desc_cat') == 1) : ?>
    					<?php if ($item->description) : ?>
            				<?php $text = JHtml::_('content.prepare', $item->description, '', 'com_newsfeeds.categories'); ?>
            				<?php $text = JFilterOutput::stripImages($text); ?>
            				<?php $text = JHtml::_('string.truncate', $text, 200); ?>
    						<div class="category-desc">
    	        				<?php echo str_replace('&apos;', "'", $text); ?>
    						</div>
    					<?php endif; ?>
    				<?php endif; ?>
    			</div>
			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
