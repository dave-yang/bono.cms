<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Blog\Service;

interface SiteServiceInterface
{
	/**
	 * Returns an array of categories with count of posts
	 * 
	 * @return array
	 */
	public function getAllCategoriesWithCount();
}