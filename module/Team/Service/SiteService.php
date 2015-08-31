<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Team\Service;

final class SiteService implements SiteServiceInterface
{
	/**
	 * Team manager service
	 * 
	 * @var \Team\Service\TeamManagerInterface
	 */
	private $teamManager;

	/**
	 * State initialization
	 * 
	 * @param \Team\Service\TeamManagerInterface $teamManager
	 * @return void
	 */
	public function __construct(TeamManagerInterface $teamManager)
	{
		$this->teamManager = $teamManager;
	}
}
