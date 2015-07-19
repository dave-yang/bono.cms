<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Cms\Controller\Install;

final class Install extends AbstractInstallController
{
	/**
	 * Index command
	 * 
	 * @return string
	 */
	public function indexAction()
	{
		return $this->view->render('install', array(
			'title' => 'Bono CMS: Installation wizard'
		));
	}

	/**
	 * Installs the system
	 * 
	 * @return string
	 */
	public function installAction()
	{
		if ($this->request->hasPost('db')) {

			$formValidator = $this->getValidator($this->request->getPost('db'));

			if ($formValidator->isValid()) {

				$result = $this->processAll();
			
				if (!$result) {
					return 'Cannot connect to database server. Make sure the data is valid';
				} else {
					//@TODO
					return '1';
				}

			} else {

				return $formValidator->getErrors();
			}
		}
	}
}