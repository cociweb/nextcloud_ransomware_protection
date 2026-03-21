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

use OCP\App\IAppManager;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\Files\ForbiddenException;
use OCP\Files\Storage\IStorage;
use OCP\IConfig;
use OCP\IRequest;
use Psr\Log\LoggerInterface;

class Analyzer {
	public const READING = 1;
	public const WRITING = 2;
	public const DELETE = 3;

	/** @var string[] */
	protected $extensionsPlain = [];
	/** @var int[] */
	protected $extensionsPlainLength = [];
	/** @var string[] */
	protected $extensionsRegex = [];

	/** @var string[] */
	protected $notesPlain = [];
	/** @var string[] */
	protected $notesRegex = [];

	/** @var string[] */
	protected $notesBiasedPlain = [];
	/** @var string[] */
	protected $notesBiasedRegex = [];

	/** @var IConfig */
	protected $config;

	/** @var ITimeFactory */
	protected $time;

	/** @var IAppManager */
	protected $appManager;

	/** @var LoggerInterface */
	protected $logger;

	/** @var Striker */
	protected $striker;

	/** @var string */
	protected $userId;

	/** @var int */
	protected $nestingLevel = 0;

	/** @var IRequest */
	protected $request;
}
