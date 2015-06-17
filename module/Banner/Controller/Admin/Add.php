<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Controller\Admin;

final class Add extends AbstractBanner
{
	/**
	 * Shows add form
	 * 
	 * @return string
	 */
	public function indexAction()
	{
		$this->loadSharedPlugins();

		return $this->view->render($this->getTemplatePath(), $this->getSharedVars(array(
			'title' => 'Add a banner',
			'banner' => $this->getBannerManager()->fetchDummy()
		)));
	}

	/**
	 * Adds a banner
	 * 
	 * @return string
	 */
	public function addAction()
	{
		$formValidator = $this->getValidator($this->request->getPost(), $this->request->getFiles());

		if ($formValidator->isValid()) {

			$bannerManager = $this->getBannerManager();

			if ($bannerManager->add($this->request->getAll())) {

				$this->flashMessenger->set('success', 'A banner has been added successfully');
				return $bannerManager->getLastId();
			}

		} else {

			return $formValidator->getErrors();
		}
	}
}
