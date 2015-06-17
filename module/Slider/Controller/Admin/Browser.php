<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Slider\Controller\Admin;

final class Browser extends AbstractBrowser
{
	/**
	 * Shows a table
	 * 
	 * @param integer $page Current page
	 * @return string
	 */
	public function indexAction($page = 1)
	{
		$this->loadSharedPlugins();
		
		$paginator = $this->getImageManager()->getPaginator();
		$paginator->setUrl('/admin/module/slider/page/%s');
		
		return $this->view->render($this->getTemplatePath(), $this->getSharedVars(array(
			
			'title' => 'Slider',
			'images' => $this->getImageManager()->fetchAllByPage($page, $this->getSharedPerPageCount()),
			'paginator' => $paginator
		)));
	}

	/**
	 * Fetches images associated with category id
	 * 
	 * @param string $categoryId
	 * @param integer $page Current page number
	 * @return string
	 */
	public function categoryAction($categoryId, $page = 1)
	{
		$this->loadSharedPlugins();

		$paginator = $this->getImageManager()->getPaginator();
		$paginator->setUrl('/admin/module/slider/category/view/'.$categoryId.'/page/%s');

		return $this->view->render($this->getTemplatePath(), $this->getSharedVars(array(
			'categoryId' => $categoryId,
			'images'	 => $this->getImageManager()->fetchAllByCategoryAndPage($categoryId, $page, $this->getSharedPerPageCount()),
			'paginator' => $paginator,
		)));
	}

	/**
	 * Deletes a category by its associated id
	 * 
	 * @return string The response
	 */
	public function deleteCategoryAction()
	{
		// Get category id from request
		$id = $this->request->getPost('id');

		// Remove all images associated with provided category id
		if ($this->getImageManager()->deleteAllByCategoryId($id) && $this->getCategoryManager()->deleteById($id)) {

			$this->flashMessenger->set('success', 'The category has been removed successfully');
			return '1';
		}
	}

	/**
	 * Deletes selected slide image
	 * 
	 * @return string
	 */
	public function deleteAction()
	{
		$id = $this->request->getPost('id');

		if ($this->getImageManager()->deleteById($id)) {

			$this->flashMessenger->set('success', 'Selected slider has been removed successfully');
			return '1';
		}
	}

	/**
	 * Removes selected records
	 * 
	 * @return string
	 */
	public function deleteSelectedAction()
	{
		if ($this->request->hasPost('toDelete')) {

			$ids = array_keys($this->request->getPost('toDelete'));

			if ($this->getImageManager()->deleteByIds($ids)) {
				$flashKey = 'success';
				$flashMessage = 'Selected slides have been removed successfully';
			}
			
		} else {

			$flashKey = 'warning';
			$flashMessage = 'You should select at least one image to remove';
		}

		$this->flashMessenger->set($flashKey, $flashMessage);
		return '1';
	}

	/**
	 * Saves settings
	 * 
	 * @return string The response
	 */
	public function saveAction()
	{
		// Get input variables first
		$published = $this->request->getPost('published');
		$orders = $this->request->getPost('order');

		$imageManager = $this->getImageManager();

		$imageManager->updatePublished($published);
		$imageManager->updateOrders($orders);

		$this->flashMessenger->set('success', 'Settings have been updated successfully');
		
		return '1';
	}
}
