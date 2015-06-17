<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Blog\Controller\Admin;

use Cms\Controller\Admin\AbstractController;

final class Config extends AbstractController
{
	/**
	 * Shows configuration form
	 * 
	 * @return string
	 */
	public function indexAction()
	{
		$this->loadPlugins();

		return $this->view->render('config', array(
			'title' => 'Configuration',
			'config' => $this->getConfigManager()->getEntity()
		));
	}

	/**
	 * Saves data from the configuration form
	 * 
	 * @return string
	 */
	public function saveAction()
	{
		$formValidator = $this->getValidator($this->request->getPost());

		if (1) {

			$this->getConfigManager()->write($this->request->getPost());
			$this->flashMessenger->set('success', "Blog's configuration has been updated successfully");

			return '1';
		
		} else {

			return $formValidator->getErrors();
		}
	}

	/**
	 * Returns prepared form validator
	 * 
	 * @param array $input Raw input data
	 * @return \Krystal\Validate\ValidatorChain
	 */
	private function getValidator(array $input)
	{
	}

	/**
	 * Loads required plugins for view
	 * 
	 * @return void
	 */
	private function loadPlugins()
	{
		$this->view->getPluginBag()
				   ->appendScript('/module/Blog/Assets/admin/config.js');

		$this->view->getBreadcrumbBag()->add(array(
			array(
				'name' => 'Blog',
				'link' => 'Blog:Admin:Browser@indexAction'
			),
			array(
				'name' => 'Configuration',
				'link' => '#'
			)
		));
	}

	/**
	 * Returns configuration manager
	 * 
	 * @return \Blog\Service\ConfigManager
	 */
	private function getConfigManager()
	{
		return $this->moduleManager->getModule('Blog')->getService('configManager');
	}
}
