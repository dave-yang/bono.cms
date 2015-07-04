<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner;

use Cms\AbstractCmsModule;
use Banner\Service\BannerManager;
use Banner\Service\SiteService;

final class Module extends AbstractCmsModule
{
	/**
	 * {@inheritDoc}
	 */
	public function getServiceProviders()
	{
		$bannerManager = new BannerManager($this->getMapper('/Banner/Storage/MySQL/BannerMapper'), $this->getHistoryManager());
		$siteService = new SiteService($bannerManager);

		return array(
			'bannerManager' => $bannerManager,
			'siteService' => $siteService
		);
	}
}
