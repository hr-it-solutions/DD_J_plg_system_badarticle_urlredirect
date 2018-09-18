<?php
/**
 * @package    DD_BadArticle_URLRedirect
 *
 * @author     HR-IT-Solutions GmbH Florian Häusler <info@hr-it-solutions.com>
 * @author     Ankit Kumar Jagetia
 * @copyright  Copyright (C) 2018 - 2018 HR-IT-Solutions GmbH
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 **/

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.access.access');

JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');

/**
 * Class PlgSystemDD_BadArticle_URLRedirect
 */
class PlgSystemDD_BadArticle_URLRedirect extends JPlugin
{

	/**
	 * Application object
	 *
	 * @var    JApplicationCms
	 * @since  3.2
	 */

	protected $app;

	/**
	 * After route.
	 *
	 * @return  void
	 *
	 * @since   3.4
	 */
	public function onAfterRoute()
	{
		// Front end
		if ($this->app->isClient('site'))
		{
			$input = $this->app->input;

			$option     = $input->get('option');
			$view       = $input->get('view');
			$id         = $input->getInt('id');
			$catid      = $input->getInt('catid');
			$exclude_id = $this->params->get('exclude_id');
			$currentURL = JUri::getInstance()->getQuery();

			if(strpos($currentURL, "&") !== false && $option === 'com_content' && $view === 'article')
			{
				$exclude_ids = array();

				foreach ($exclude_id as $item)
				{
					array_push($exclude_ids, $item->exclude_id);
				}

				if(!in_array($id, $exclude_ids) && (substr( $_SERVER['REQUEST_URI'], 0, 14 ) !== "/?view=article"))
				{
					$url = JRoute::_(ContentHelperRoute::getArticleRoute($id, $catid));

					$this->app->redirect($url);
				}
			}
		}
	}
}
