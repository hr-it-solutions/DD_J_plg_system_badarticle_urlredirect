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

class PlgSystemDD_BadArticle_URLRedirect extends JPlugin
{

	protected $app;

	public function onAfterRoute() {

		$input = $this->app->input;

		$option = $input->get('option', '');
		$view   = $input->get('view', '');
		$id     = $input->get('id', '', 'INT');
		$catid  = $input->get('catid', 0, 'INT');

		$currentURL = JUri::getInstance()->getQuery();

		if ((strpos($currentURL,"&") !== false) AND ($option === 'com_content' && $view === 'article')){

			$url = JRoute::_(ContentHelperRoute::getArticleRoute($id, $catid));

			$this->app->redirect($url);
		}
	}
}