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

$params				  = &$this->item->params;
$this->item->image_class = 'u-sizeFit';
$useDefList			  = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
		|| $params->get('show_category'));
?>
				<div class="Grid u-layout-centerContent">
					<div class="Grid-cell u-sizeFit">
					<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
					</div>
					<div class="Grid-cell u-md-sizeFill u-lg-sizeFill u-padding-r-left">
						<div class="u-color-grey-30 u-border-top-xxs u-padding-right-xxl u-padding-r-all">
							<?php if ($useDefList) : ?>
							<p class="u-padding-r-bottom">
								<?php if ($params->get('show_category')) : ?>
									<?php echo JLayoutHelper::render('joomla.content.info_block.category', array('item' => $this->item, 'params' => $params)); ?>
								<?php endif; ?>
								<?php if ($params->get('show_modify_date')) : ?>
									<?php echo JLayoutHelper::render('joomla.content.info_block.modify_date', array('item' => $this->item, 'params' => $params)); ?>
								<?php endif; ?>
								<?php if ($params->get('show_publish_date')) : ?>
									<?php echo JLayoutHelper::render('joomla.content.info_block.publish_date', array('item' => $this->item, 'params' => $params)); ?>
								<?php endif; ?>
								<?php if ($params->get('show_create_date')) : ?>
									<?php echo JLayoutHelper::render('joomla.content.info_block.create_date', array('item' => $this->item, 'params' => $params)); ?>
								<?php endif; ?>
							</p>
							<?php endif; ?>
							<?php if ($params->get('show_title')) : ?>
							<h3 class="u-padding-r-top u-padding-r-bottom" itemprop="headline">
								<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
									<a class="u-text-h4 u-textClean u-color-black" href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>" itemprop="url">
										<?php echo $this->escape($this->item->title); ?>
									</a>
								<?php else : ?>
									<span class="u-text-h4 u-linkClean u-color-black">
										<?php echo $this->escape($this->item->title); ?>
									</span>
								<?php endif; ?>
							</h3>
							<?php endif; ?>
							<div class="u-lineHeight-l u-text-r-xs u-textSecondary u-padding-r-right">
							<?php if (!$params->get('show_intro')) : ?>
								<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
								<?php echo $this->item->event->afterDisplayTitle; ?>
							<?php endif; ?>
							<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
							<?php echo $this->item->event->beforeDisplayContent; ?>

							<?php echo $this->item->introtext; ?>

							<?php if ($params->get('show_readmore') && $this->item->readmore) :
								if ($params->get('access-view')) :
									$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
								else :
									$menu = JFactory::getApplication()->getMenu();
									$active = $menu->getActive();
									$itemId = $active->id;
									$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
									$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
								endif; ?>

								<?php echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

							<?php endif; ?>
							</div>
						</div>

					</div>
				</div>
