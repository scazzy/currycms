<?php
/**
 * Curry CMS
 *
 * LICENSE
 *
 * This source file is subject to the GPL license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://currycms.com/license
 *
 * @category   Curry CMS
 * @package    Curry
 * @copyright  2011-2012 Bombayworks AB (http://bombayworks.se)
 * @license    http://currycms.com/license GPL
 * @link       http://currycms.com
 */

/**
 * Shows the Live edit (aka Inline Admin) view of the webpage.
 *
 * @package Curry\Backend
 *
 */
class Curry_Backend_InlineAdmin extends Curry_Backend
{
	/** {@inheritdoc} */
	public static function getGroup()
	{
		return "Content";
	}

	/** {@inheritdoc} */
	public static function getName()
	{
		return "Live edit";
	}

	/** {@inheritdoc} */
	public function showMain()
	{
		if(!Curry_Core::$config->curry->liveEdit) {
			$this->addMessage('Live edit is not enabled, go to <a href="'.url('', array('module' => 'Curry_Backend_System')).'">System Settings</a> to enable it.', Curry_Backend::MSG_WARNING, false);
			return;
		}
		
		$page = false;
		if(isset($_GET['page_id']))
			$page = PageQuery::create()
				->findOneByPageId($_GET['page_id']);

		$this->showPage($page ? $page->getUrl() : '/');
	}
	
	/**
	 * Embed iframe for url.
	 *
	 * @param string $url
	 */
	public function showPage($url)
	{
		$url .= '?curry_inline_admin=true';
		Curry_Admin::getInstance()->addBodyClass('tpl-fullscreen');
		url($url)->redirect();
		$this->addMainContent('<iframe id="inline-admin-preview" src="'.$url.'" frameborder="0" width="100%" height="100%"></iframe>');
	}

}