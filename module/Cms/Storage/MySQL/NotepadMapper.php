<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Cms\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use Cms\Storage\NotepadMapperInterface;

final class NotepadMapper extends AbstractMapper implements NotepadMapperInterface
{
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'bono_module_cms_notepad';

	/**
	 * Checks whether notepad's data with provided user's id exists
	 * 
	 * @param string $userId
	 * @return boolean
	 */
	public function exists($userId)
	{
		return (bool) $this->db->select()
						->count('user_id', 'count')
						->from($this->table)
						->whereEquals('user_id', $userId)
						->query('count');
	}

	/**
	 * Inserts notepad's data
	 * 
	 * @param string $userId
	 * @param string $content
	 * @return boolean
	 */
	public function insert($userId, $content)
	{
		return $this->db->insert($this->table, array(
			
			'user_id' => $userId,
			'content' => $content
			
		))->execute();
	}

	/**
	 * Updates notepad's data
	 * 
	 * @param string $userId
	 * @param string $content
	 * @return boolean
	 */
	public function update($userId, $content)
	{
		return $this->db->update($this->table, array('content' => $content))
						->whereEquals('user_id', $userId)
						->execute();
	}

	/**
	 * Fetches notepad's content by associated user id
	 * 
	 * @param string $userId
	 * @return string
	 */
	public function fetchByUserId($userId)
	{
		return $this->db->select('content')
						->from($this->table)
						->whereEquals('user_id', $userId)
						->query('content');
	}
}
