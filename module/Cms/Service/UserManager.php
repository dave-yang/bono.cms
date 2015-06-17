<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) 2015 David Yang <daworld.ny@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Cms\Service;

use Cms\Service\AbstractManager;
use Cms\Storage\UserMapperInterface;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Authentication\AuthManagerInterface;
use Krystal\Authentication\UserAuthServiceInterface;
use Krystal\Security\Filter;

final class UserManager extends AbstractManager implements UserManagerInterface, UserAuthServiceInterface
{
	/**
	 * Any compliant user mapper
	 * 
	 * @var \Cms\Storage\UserMapperInteface
	 */
	private $userMapper;

	/**
	 * Authorization manager
	 * 
	 * @var \Krystal\Authentication\AuthManagerInterface
	 */
	private $authManager;

	/**
	 * State initialization
	 * 
	 * @param \Cms\Storage\UserMapperInteface $userMapper Any mapper which implements this interface
	 * @param \Krystal\Authentication\AuthManagerInterface $authManager
	 * @return void
	 */
	public function __construct(UserMapperInterface $userMapper, AuthManagerInterface $authManager)
	{
		$this->userMapper = $userMapper;
		$this->authManager = $authManager;
	}

	/**
	 * Fetches user's name by associated id
	 * 
	 * @param string $id
	 * @return array
	 */
	public function fetchNameById($id)
	{
		// This method is called inside foreach, so we need a cache anyway
		static $cache = array();

		if (isset($cache[$id])) {
			// $cache[$id] represent user name
			return $cache[$id];

		} else {
			$name = $this->userMapper->fetchNameById($id);
			$cache[$id] = $name;

			return $name;
		}
	}

	/**
	 * Returns last added user's` id
	 * 
	 * @return integer
	 */
	public function getLastId()
	{
		return $this->userMapper->getLastId();
	}

	/**
	 * {@inheritDoc}
	 */
	protected function toEntity(array $user)
	{
		$entity = new VirtualEntity();
		$entity->setId((int) $user['id'])
			->setLogin($user['login'])
			->setPasswordHash($user['password_hash'])
			->setRole(Filter::escape($user['role']))
			->setEmail(Filter::escape($user['email']))
			->setName(Filter::escape($user['name']));
			
		return $entity;
	}

	/**
	 * Fetches dummy user's entity
	 * 
	 * @return \Krystal\Stdlib\VirtualEntity
	 */
	public function fetchDummy()
	{
		return $this->toEntity(array(
			'id' => null,
			'login' => null,
			'password_hash' => null,
			'role' => null,
			'email' => null,
			'name' => null
		));
	}
	
	public function getId()
	{
		return $this->authManager->getId();
	}
	
	public function getRole()
	{
		return $this->authManager->getRole();
	}

	/**
	 * Attempts to authenticate a user
	 * 
	 * @param string $login
	 * @param string $password
	 * @param boolean $remember Whether to remember
	 * @param boolean $hash Whether to hash password
	 * @return boolean
	 */
	public function authenticate($login, $password, $remember, $hash = true)
	{
		if ($hash === true) {
			$password = $this->getHash($password);
		}

		$user = $this->userMapper->fetchByCredentials($login, $password);

		// If it's not empty. then login and password are both value
		if (!empty($user)) {
			
			$this->authManager->storeId($user['id'])
							  ->storeRole($user['role'])
							  ->login($login, $password, $remember);
			return true;
		}

		return false;
	}

	/**
	 * Log-outs a user
	 * 
	 * @return void
	 */
	public function logout()
	{
		return $this->authManager->logout();
	}

	/**
	 * Checks whether a user is logged in
	 * 
	 * @return boolean
	 */
	public function isLoggedIn()
	{
		return $this->authManager->isLoggedIn();
	}

	/**
	 * Disables authorization checking
	 * 
	 * @return void
	 */
	public function disableAuthCheck()
	{
		$this->authManager->setActive(false);
	}

	/**
	 * Provides a hash of a string
	 * 
	 * @param string $string
	 * @return string
	 */
	private function getHash($string)
	{
		return sha1($string);
	}

	/**
	 * Adds an user
	 * 
	 * @param array $input Raw input data
	 * @return boolean Depending on success
	 */
	public function add(array $input)
	{
		$input['password_hash'] = $this->getHash($input['password']);
		return $this->userMapper->insert($input);
	}

	/**
	 * Updates an user
	 * 
	 * @param array $input Raw input data
	 * @return boolean
	 */
	public function update(array $input)
	{
		if (!empty($input['password'])) {
			$input['password_hash'] = $this->getHash($input['password']);
		}

		return $this->userMapper->update($input);
	}

	/**
	 * Deletes a user by its associated id
	 * 
	 * @param string $id User's id
	 * @return boolean
	 */
	public function deleteById($id)
	{
		return $this->userMapper->deleteById($id);
	}

	/**
	 * Fetches a user's bag by its associated
	 * 
	 * @param string $id User's id
	 * @return array
	 */
	public function fetchById($id)
	{
		return $this->prepareResult($this->userMapper->fetchById($id));
	}

	/**
	 * Fetches all user entities
	 * 
	 * @return array
	 */
	public function fetchAll()
	{
		return $this->prepareResults($this->userMapper->fetchAll());
	}
}
