<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace QA\Controller\Admin;

use Cms\Controller\Admin\AbstractController;

abstract class AbstractQa extends AbstractController
{
	/**
	 * Returns prepared and configured validator's instance
	 * 
	 * @param array $post
	 * @return Validator
	 */
	final protected function getValidator(array $post)
	{
		//@TODO
		return $this->validatorFactory->build(array(
			'input' => array(
				'source' => $post,
				'definition' => array(
					'question' => array(
						'required' => true,
						'rules' => array(
							'NotEmpty' => array(
								'message' => 'Question is required'
							)
						)
					),
					
					'questioner' => array(
						'required' => true,
						'rules' => array(
							'NotEmpty' => array(
								'message' => 'Questioner is required'
							)
						)
					),
					
					'answerer' => array(
						'required' => true,
						'rules' => array(
							'NotEmpty' => array(
								'message' => 'Answerer is required'
							)
						)
					)
				)
			)
		));
	}

	/**
	 * Returns Qa manager
	 * 
	 * @return \Qa\Service\QaManager 
	 */
	final protected function getQaManager()
	{
		return $this->moduleManager->getModule('QA')->getService('qaManager');
	}

	/**
	 * Returns template path
	 * 
	 * @return string
	 */
	final protected function getTemplatePath()
	{
		return 'qa.form';
	}

	/**
	 * Returns shared variables for Add and Edit controllers
	 * 
	 * @param array $overrides
	 * @return array
	 */
	final protected function getSharedVars(array $overrides)
	{
		$qa = $this->moduleManager->getModule('QA');

		$this->view->getBreadcrumbBag()->add(array(
			array(
				'link' => 'QA:Admin:Browser@indexAction',
				'name' => 'Questions and Answers'
			),
			array(
				'link' => '#',
				'name' => $overrides['title']
			)
		));
		
		$vars = array(
			'timeFormat' => $qa->getService('qaManager')->getTimeFormat()
		);

		return array_replace_recursive($vars, $overrides);
	}

	/**
	 * Loads shared plugins
	 * 
	 * @return void
	 */
	final protected function loadSharedPlugins()
	{
		$this->view->getPluginBag()
				   ->appendScript($this->getWithAssetPath('/admin/qa.form.js'))
				   ->load($this->getWysiwygPluginName());
	}
}
