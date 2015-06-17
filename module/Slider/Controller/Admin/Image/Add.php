<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Slider\Controller\Admin\Image;

final class Add extends AbstractImage
{
	/**
	 * Shows the adding form
	 * 
	 * @return string
	 */
	public function indexAction()
	{
		$this->view->getPluginBag()->load('preview')
								   ->appendScript($this->getWithAssetPath('/admin/image.add.js'));
		
		return $this->view->render($this->getTemplatePath(), $this->getSharedVars(array(
			'title' => 'Add a slider',
			'image' => $this->getImageManager()->fetchDummy()
		)));
	}

	/**
	 * Adds a slider
	 * 
	 * @return string
	 */
	public function addAction()
	{
		$formValidator = $this->getValidator($this->request->getPost(), $this->request->getFiles());

		if ($formValidator->isValid()) {

			$imageManager = $this->getImageManager();

			if ($imageManager->add($this->request->getAll())) {

				$this->flashMessenger->set('success', 'A slider has been added successfully');
				return $imageManager->getLastId();
			}

		} else {
			return $formValidator->getErrors();
		}
	}
}
