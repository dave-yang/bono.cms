<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Menu\Contract;

use Cms\Service\WebPageManagerInterface;

interface WebPageAwareRendererInterface
{
	/**
	 * Sets web page manager that can generate URLs
	 * 
	 * @param \Cms\Service\WebPageManagerInterface $webPageManager
	 * @return void
	 */
	public function setWebPageManager(WebPageManagerInterface $webPageManager);
}
