<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Block\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use Block\Storage\BlockMapperInterface;

final class BlockMapper extends AbstractMapper implements BlockMapperInterface
{
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'Krystal_module_block';

	/**
	 * Fetches block's content by its associated class name
	 * 
	 * @param string $class
	 * @return string
	 */
	public function fetchContentByClass($class)
	{
		return $this->db->select('content')
						->from($this->table)
						->whereEquals('class', $class)
						->andWhereEquals('lang_id', $this->getLangId())
						->query('content');
	}

	/**
	 * Fetches block name by its associated id
	 * 
	 * @param string $id
	 * @return string
	 */
	public function fetchNameById($id)
	{
		return $this->db->select('name')
						->from($this->table)
						->whereEquals('id', $id)
						->query('name');
	}

	/**
	 * Fetches block data by its associated class name
	 * 
	 * @param string $class Block's class name
	 * @return array
	 */
	public function fetchByClass($class)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('class', $class)
						->andWhereEquals('lang_id', $this->getLangId())
						->query();
	}

	/**
	 * Fetches all blocks
	 * 
	 * @return array
	 */
	public function fetchAll()
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('lang_id', $this->getLangId())
						->queryAll();
	}

	/**
	 * Counts all blocks
	 * 
	 * @return integer
	 */
	private function countAll()
	{
		return $this->db->select()
						->count('id', 'count')
						->from($this->table)
						->whereEquals('lang_id', $this->getLangId())
						->query('count');
	}

	/**
	 * Fetches all blocks filtered by pagination
	 * 
	 * @param integer $page Current page
	 * @param integer $perPageCount Per page count
	 * @return array
	 */
	public function fetchAllByPage($page, $perPageCount)
	{
		$this->paginator->setTotalAmount($this->countAll())
						->setItemsPerPage($perPageCount)
						->setCurrentPage($page);
		
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('lang_id', $this->getLangId())
						->orderBy('id')
						->desc()
						->limit($this->paginator->countOffset(), $this->paginator->getItemsPerPage())
						->queryAll();
	}

	/**
	 * Fetches block data by its associated id
	 * 
	 * @param string $id Block id
	 * @return array
	 */
	public function fetchById($id)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('id', $id)
						->query();
	}

	/**
	 * Inserts block's data
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function insert(array $data)
	{
		return $this->db->insert($this->table, array(
			
			'lang_id'	=> $this->getLangId(),
			'name'		=> $data['name'],
			'content'	=> $data['content'],
			'class'		=> $data['class']
			
		))->execute();
	}

	/**
	 * Updates block's data
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function update(array $data)
	{
		return $this->db->update($this->table, array(
			
			'name'		=> $data['name'],
			'content'	=> $data['content'],
			'class'		=> $data['class']
			
		))->whereEquals('id', $data['id'])
		  ->execute();
	}

	/**
	 * Deletes a block by its associated id
	 * 
	 * @param string $id Block id
	 * @return boolean Depending on success
	 */
	public function deleteById($id)
	{
		return $this->db->delete()
						->from($this->table)
						->whereEquals('id', $id)
						->execute();
	}
}
