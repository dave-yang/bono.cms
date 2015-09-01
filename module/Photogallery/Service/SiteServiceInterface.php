<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Photogallery\Service;

interface SiteServiceInterface
{
	/**
	 * Fetches all photo entities by associated album id
	 * 
	 * @param string $id Album id
	 * @return array
	 */
	public function getAllByAlbumId($id);
}