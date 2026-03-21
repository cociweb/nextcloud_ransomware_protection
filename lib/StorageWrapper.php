<?php

/**
 * @copyright Copyright (c) 2017 Joas Schilling <coding@schilljs.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\RansomwareProtection;

use OC\Files\Storage\Wrapper\Wrapper;
use OCP\Files\ForbiddenException;
use OCP\Files\Storage\IStorage;

/**
 * @psalm-suppress UnusedClass
 */
class StorageWrapper extends Wrapper {

	/** @var Analyzer */
	protected $analyzer;

	/*
	 * Storage wrapper methods
	 */

	//	/**
	//	 * see http://php.net/manual/en/function.mkdir.php
	//	 *
	//	 * @param string $path
	//	 * @return bool
	//	 */
	//	public function mkdir($path) {
	//		return $this->storage->mkdir($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.rmdir.php
	//	 *
	//	 * @param string $path
	//	 * @return bool
	//	 */
	//	public function rmdir($path) {
	//		return $this->storage->rmdir($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.opendir.php
	//	 *
	//	 * @param string $path
	//	 * @return resource
	//	 */
	//	public function opendir($path) {
	//		return $this->storage->opendir($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.is_dir.php
	//	 *
	//	 * @param string $path
	//	 * @return bool
	//	 */
	//	public function is_dir($path) {
	//		return $this->storage->is_dir($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.is_file.php
	//	 *
	//	 * @param string $path
	//	 * @return bool
	//	 */
	//	public function is_file($path) {
	//		return $this->storage->is_file($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.stat.php
	//	 * only the following keys are required in the result: size and mtime
	//	 *
	//	 * @param string $path
	//	 * @return array
	//	 */
	//	public function stat($path) {
	//		return $this->storage->stat($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.filetype.php
	//	 *
	//	 * @param string $path
	//	 * @return bool
	//	 */
	//	public function filetype($path) {
	//		return $this->storage->filetype($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.filesize.php
	//	 * The result for filesize when called on a folder is required to be 0
	//	 *
	//	 * @param string $path
	//	 * @return int
	//	 */
	//	public function filesize($path) {
	//		return $this->storage->filesize($path);
	//	}

	//	/**
	//	 * check if a file can be shared
	//	 *
	//	 * @param string $path
	//	 * @return bool
	//	 */
	//	public function isSharable($path) {
	//		return $this->storage->isSharable($path);
	//	}
	//
	//	/**
	//	 * get the full permissions of a path.
	//	 * Should return a combination of the PERMISSION_ constants defined in lib/public/constants.php
	//	 *
	//	 * @param string $path
	//	 * @return int
	//	 */
	//	public function getPermissions($path) {
	//		return $this->storage->getPermissions($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.file_exists.php
	//	 *
	//	 * @param string $path
	//	 * @return bool
	//	 */
	//	public function file_exists($path) {
	//		return $this->storage->file_exists($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.filemtime.php
	//	 *
	//	 * @param string $path
	//	 * @return int
	//	 */
	//	public function filemtime($path) {
	//		return $this->storage->filemtime($path);
	//	}

	//	/**
	//	 * get the mimetype for a file or folder
	//	 * The mimetype for a folder is required to be "httpd/unix-directory"
	//	 *
	//	 * @param string $path
	//	 * @return string
	//	 */
	//	public function getMimeType($path) {
	//		return $this->storage->getMimeType($path);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.hash.php
	//	 *
	//	 * @param string $type
	//	 * @param string $path
	//	 * @param bool $raw
	//	 * @return string
	//	 */
	//	public function hash($type, $path, $raw = false) {
	//		return $this->storage->hash($type, $path, $raw);
	//	}
	//
	//	/**
	//	 * see http://php.net/manual/en/function.free_space.php
	//	 *
	//	 * @param string $path
	//	 * @return int
	//	 */
	//	public function free_space($path) {
	//		return $this->storage->free_space($path);
	//	}
	//
	//	/**
	//	 * search for occurrences of $query in file names
	//	 *
	//	 * @param string $query
	//	 * @return array
	//	 */
	//	public function search($query) {
	//		return $this->storage->search($query);
	//	}

	//	/**
	//	 * get the path to a local version of the file.
	//	 * The local version of the file can be temporary and doesn't have to be persistent across requests
	//	 *
	//	 * @param string $path
	//	 * @return string
	//	 */
	//	public function getLocalFile($path) {
	//		return $this->storage->getLocalFile($path);
	//	}
	//
	//	/**
	//	 * check if a file or folder has been updated since $time
	//	 *
	//	 * @param string $path
	//	 * @param int $time
	//	 * @return bool
	//	 *
	//	 * hasUpdated for folders should return at least true if a file inside the folder is add, removed or renamed.
	//	 * returning true for other changes in the folder is optional
	//	 */
	//	public function hasUpdated($path, $time) {
	//		return $this->storage->hasUpdated($path, $time);
	//	}

	//	/**
	//	 * get a scanner instance for the storage
	//	 *
	//	 * @param string $path
	//	 * @param \OC\Files\Storage\Storage (optional) the storage to pass to the scanner
	//	 * @return \OC\Files\Cache\Scanner
	//	 */
	//	public function getScanner($path = '', $storage = null) {
	//		if (!$storage) {
	//			$storage = $this;
	//		}
	//		return $this->storage->getScanner($path, $storage);
	//	}
	//
	//
	//	/**
	//	 * get the user id of the owner of a file or folder
	//	 *
	//	 * @param string $path
	//	 * @return string
	//	 */
	//	public function getOwner($path) {
	//		return $this->storage->getOwner($path);
	//	}
	//
	//	/**
	//	 * get a watcher instance for the cache
	//	 *
	//	 * @param string $path
	//	 * @param \OC\Files\Storage\Storage (optional) the storage to pass to the watcher
	//	 * @return \OC\Files\Cache\Watcher
	//	 */
	//	public function getWatcher($path = '', $storage = null) {
	//		if (!$storage) {
	//			$storage = $this;
	//		}
	//		return $this->storage->getWatcher($path, $storage);
	//	}
	//
	//	public function getPropagator($storage = null) {
	//		if (!$storage) {
	//			$storage = $this;
	//		}
	//		return $this->storage->getPropagator($storage);
	//	}
	//
	//	public function getUpdater($storage = null) {
	//		if (!$storage) {
	//			$storage = $this;
	//		}
	//		return $this->storage->getUpdater($storage);
	//	}
	//
	//	/**
	//	 * @return \OC\Files\Cache\Storage
	//	 */
	//	public function getStorageCache() {
	//		return $this->storage->getStorageCache();
	//	}
	//
	//	/**
	//	 * get the ETag for a file or folder
	//	 *
	//	 * @param string $path
	//	 * @return string
	//	 */
	//	public function getETag($path) {
	//		return $this->storage->getETag($path);
	//	}
	//
	//	/**
	//	 * Returns true
	//	 *
	//	 * @return true
	//	 */
	//	public function test() {
	//		return $this->storage->test();
	//	}
	//
	//	/**
	//	 * Returns the wrapped storage's value for isLocal()
	//	 *
	//	 * @return bool wrapped storage's isLocal() value
	//	 */
	//	public function isLocal() {
	//		return $this->storage->isLocal();
	//	}
	//
	//	/**
	//	 * Check if the storage is an instance of $class or is a wrapper for a storage that is an instance of $class
	//	 *
	//	 * @param string $class
	//	 * @return bool
	//	 */
	//	public function instanceOfStorage($class) {
	//		return is_a($this, $class) or $this->storage->instanceOfStorage($class);
	//	}
	//
	//	/**
	//	 * Pass any methods custom to specific storage implementations to the wrapped storage
	//	 *
	//	 * @param string $method
	//	 * @param array $args
	//	 * @return mixed
	//	 */
	//	public function __call($method, $args) {
	//		return call_user_func_array(array($this->storage, $method), $args);
	//	}

	//	/**
	//	 * Get availability of the storage
	//	 *
	//	 * @return array [ available, last_checked ]
	//	 */
	//	public function getAvailability() {
	//		return $this->storage->getAvailability();
	//	}
	//
	//	/**
	//	 * Set availability of the storage
	//	 *
	//	 * @param bool $isAvailable
	//	 */
	//	public function setAvailability($isAvailable) {
	//		$this->storage->setAvailability($isAvailable);
	//	}
	//
	//	/**
	//	 * @param string $path the path of the target folder
	//	 * @param string $fileName the name of the file itself
	//	 * @return void
	//	 * @throws InvalidPathException
	//	 */
	//	public function verifyPath($path, $fileName) {
	//		$this->storage->verifyPath($path, $fileName);
	//	}

	//	/**
	//	 * @param string $path
	//	 * @return array
	//	 */
	//	public function getMetaData($path) {
	//		return $this->storage->getMetaData($path);
	//	}
	//
	//	/**
	//	 * @param string $path
	//	 * @param int $type \OCP\Lock\ILockingProvider::LOCK_SHARED or \OCP\Lock\ILockingProvider::LOCK_EXCLUSIVE
	//	 * @param \OCP\Lock\ILockingProvider $provider
	//	 * @throws \OCP\Lock\LockedException
	//	 */
	//	public function acquireLock($path, $type, ILockingProvider $provider) {
	//		if ($this->storage->instanceOfStorage('\OCP\Files\Storage\ILockingStorage')) {
	//			$this->storage->acquireLock($path, $type, $provider);
	//		}
	//	}
	//
	//	/**
	//	 * @param string $path
	//	 * @param int $type \OCP\Lock\ILockingProvider::LOCK_SHARED or \OCP\Lock\ILockingProvider::LOCK_EXCLUSIVE
	//	 * @param \OCP\Lock\ILockingProvider $provider
	//	 */
	//	public function releaseLock($path, $type, ILockingProvider $provider) {
	//		if ($this->storage->instanceOfStorage('\OCP\Files\Storage\ILockingStorage')) {
	//			$this->storage->releaseLock($path, $type, $provider);
	//		}
	//	}
	//
	//	/**
	//	 * @param string $path
	//	 * @param int $type \OCP\Lock\ILockingProvider::LOCK_SHARED or \OCP\Lock\ILockingProvider::LOCK_EXCLUSIVE
	//	 * @param \OCP\Lock\ILockingProvider $provider
	//	 */
	//	public function changeLock($path, $type, ILockingProvider $provider) {
	//		if ($this->storage->instanceOfStorage('\OCP\Files\Storage\ILockingStorage')) {
	//			$this->storage->changeLock($path, $type, $provider);
	//		}
	//	}
}
