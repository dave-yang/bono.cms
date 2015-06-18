<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace News\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use News\Storage\PostMapperInterface;

final class PostMapper extends AbstractMapper implements PostMapperInterface
{
	/**
	 * {@inheritDoc}
	 */
	protected $table = 'bono_module_news_posts';

	/**
	 * Removes all web pages by associated category id
	 * 
	 * @param string $categoryId
	 * @return boolean
	 */
	public function fetchAllWebPageIdsByCategoryId($categoryId)
	{
		return $this->db->select('web_page_id')
						->from($this->table)
						->whereEquals('category_id', $categoryId)
						->queryAll('web_page_id');
	}

	/**
	 * Fetches all post ids associated with provided category id
	 * 
	 * @param string $categoryId
	 * @return array
	 */
	public function fetchAllIdsWithImagesByCategoryId($categoryId)
	{
		return $this->db->select('id')
						->from($this->table)
						->whereEquals('category_id', $categoryId)
						->andWhereNotEquals('cover', '')
						->queryAll('id');
	}

	/**
	 * Updates post column's value by its associated id
	 * 
	 * @param string $id Post id
	 * @param string $column Target column
	 * @param string $value New value
	 * @return boolean
	 */
	private function updateColumnById($id, $column, $value)
	{
		return $this->db->update($this->table, array($column => $value))
						->whereEquals('id', $id)
						->execute();
	}

	/**
	 * Update post's published state by its associated id
	 * 
	 * @param string $id Post id
	 * @param string $published Either 0 or 1
	 * @return boolean
	 */
	public function updatePublishedById($id, $published)
	{
		return $this->updateColumnById($id, 'published', $published);
	}

	/**
	 * Updates whether post's seo is enabled or not by its associated id
	 * 
	 * @param string $id Post id
	 * @param string $published Either 0 or 1
	 * @return boolean
	 */
	public function updateSeoById($id, $seo)
	{
		return $this->updateColumnById($id, 'seo', $seo);
	}

	/**
	 * Inserts a post
	 * 
	 * @param array $input Raw input data
	 * @return boolean Depending on success
	 */
	public function insert(array $input)
	{
		return $this->db->insert($this->table, array(

			'lang_id'			=> $this->getLangId(),
			'web_page_id'		=> $input['webPageId'],
			'category_id'		=> $input['categoryId'],
			'published'			=> $input['published'],
			'seo'				=> $input['seo'],
			'title'				=> $input['title'],
			'intro'				=> $input['intro'],
			'full'				=> $input['full'],
			'timestamp'			=> $input['timestamp'],
			'keywords'			=> $input['keywords'],
			'meta_description'	=> $input['metaDescription'],
			'cover'				=> $input['cover']

		))->execute();
	}

	/**
	 * Updates a post
	 * 
	 * @param array $input Raw input data
	 * @return boolean
	 */
	public function update(array $input)
	{
		return $this->db->update($this->table, array(

			'category_id' => $input['categoryId'],
			'published'   => $input['published'],
			'seo' 		  => $input['seo'],
			'title'		  => $input['title'],
			'intro'		  => $input['intro'],
			'full'        => $input['full'],
			'keywords'    => $input['keywords'],
			'meta_description' => $input['metaDescription'],
			'cover'		 => $input['cover']

		))->whereEquals('id', $input['id'])
		  ->execute();
	}

	/**
	 * Deletes a post by its associated id
	 * 
	 * @param string $id Post id
	 * @return boolean
	 */
	public function deleteById($id)
	{
		return $this->db->delete()
						->from($this->table)
						->whereEquals('id', $id)
						->execute();
	}

	/**
	 * Deletes all posts associated with given category id
	 * 
	 * @param string $categoryId
	 * @return boolean
	 */
	public function deleteAllByCategoryId($categoryId)
	{
		return $this->db->delete()
						->from($this->table)
						->whereEquals('category_id', $categoryId)
						->execute();
	}

	/**
	 * Fetches all posts
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
	 * Fetches all published posts
	 * 
	 * @return array
	 */
	public function fetchAllPublished()
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('published', '1')
						->andWhereEquals('lang_id', $this->getLangId())
						->orderBy('timestamp')
						->queryAll();
	}

	/**
	 * Fetches all published posts associated with given category id
	 * 
	 * @param string $categoryId
	 * @param integer $limit Limit for posts to be fetched
	 * @return array
	 */
	public function fetchAllPublishedByCategoryId($categoryId, $limit)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('category_id', $categoryId)
						->andWhereEquals('published', '1')
						->orderBy('id')
						->desc()
						->limit($limit)
						->queryAll();
	}

	/**
	 * Fetches all posts filtered by pagination
	 * 
	 * @param integer $page Current page
	 * @param integer $itemsPerPage Per page count
	 * @return array
	 */
	public function fetchAllByPage($page, $itemsPerPage)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('lang_id', $this->getLangId())
						->orderBy('id')
						->desc()
						->paginate($page, $itemsPerPage)
						->queryAll();
	}

	/**
	 * Fetches all published posts
	 * 
	 * @param string $page Current page
	 * @param string $itemsPerPage Per page count
	 * @return array
	 */
	public function fetchAllPublishedByPage($page, $itemsPerPage)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('published', '1')
						->andWhereEquals('lang_id', $this->getLangId())
						->orderBy('id')
						->desc()
						->paginate($page, $itemsPerPage)
						->queryAll();
	}

	/**
	 * Fetches all published posts by category id and filtered by pagination
	 * 
	 * @param string $categoryId
	 * @param integer $page Current page number
	 * @param integer $itemsPerPage Per page count
	 * @return array
	 */
	public function fetchAllPublishedByCategoryIdAndPage($categoryId, $page, $itemsPerPage)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('category_id', $categoryId)
						->andWhereEquals('published', '1')
						->orderBy('id')
						->desc()
						->paginate($page, $itemsPerPage)
						->queryAll();
	}

	/**
	 * Fetches all posts by associated category id and filtered by pagination
	 * 
	 * @param string $categoryId
	 * @param integer $page Current page number
	 * @param integer $itemsPerPage Per page count
	 * @return array
	 */
	public function fetchAllByCategoryIdAndPage($categoryId, $page, $itemsPerPage)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('category_id', $categoryId)
						->orderBy('id')
						->desc()
						->paginate($page, $itemsPerPage)
						->queryAll();
	}

	/**
	 * Fetches post title by its associated id
	 * 
	 * @param string $id Post id
	 * @return string
	 */
	public function fetchTitleById($id)
	{
		return $this->db->select('title')
						->from($this->table)
						->whereEquals('id', $id)
						->query('title');
	}

	/**
	 * Counts all posts by associated category id
	 * Public intentionally
	 * 
	 * @param string $categoryId
	 * @return integer
	 */
	public function countAllByCategoryId($categoryId)
	{
		return $this->db->select()
						->count('id', 'count')
						->from($this->table)
						->whereEquals('category_id', $categoryId)
						->query('count');
	}

	/**
	 * Fetches post data by its associated id
	 * 
	 * @param string $id Post id
	 * @return array
	 */
	public function fetchById($id)
	{
		return $this->db->select('*')
						->from($this->table)
						->whereEquals('id', $id)
						->query();
	}
}
