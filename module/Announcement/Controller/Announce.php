<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Announcement\Controller;

use Site\Controller\AbstractController;

final class Announce extends AbstractController
{
	/**
	 * Shows an announce
	 * 
	 * @param string $id Announce's id
	 * @return string
	 */
	public function indexAction($id)
	{
		$announceManager = $this->moduleManager->getModule('Announcement')->getService('announceManager');
		$announce = $announceManager->fetchById($id);

		if ($announce !== false) {
			return $this->view->render('page', array(

				'breadcrumbs' => $announceManager->getBreadcrumbs($announce),
				'page' => $announce
			));

		} else {

			return false;
		}
	}
}
