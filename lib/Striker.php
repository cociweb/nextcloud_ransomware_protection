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

use OCP\AppFramework\Utility\ITimeFactory;
use OCP\Files\ForbiddenException;
use OCP\IConfig;
use OCP\Notification\IManager;
use Psr\Log\LoggerInterface;

class Striker {
	public const FIRST_STRIKE = 1;
	public const ALREADY_STRIKED = 2;
	public const FIFTH_STRIKE = 3;
	public const EXTERNAL_STRIKE = 4;

	/** @var IConfig */
	protected $config;

	/** @var ITimeFactory */
	protected $time;

	/** @var IManager */
	protected $notifications;

	/** @var LoggerInterface */
	protected $logger;

	/** @var string */
	protected $userId;

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 * @param array $lastStrikes
	 * @param string $path
	 * @return int
	 */
	protected function checkLastStrikes(array $lastStrikes, $path) {
		$thirtyMinutesAgo = $this->time->getTime() - 30 * 60;

		$recentStrikes = 0;
		foreach ($lastStrikes as $strike) {
			if ($strike['path'] === $path && $strike['time'] > $thirtyMinutesAgo) {
				return self::ALREADY_STRIKED;
			}
			if ($strike['time'] > $thirtyMinutesAgo) {
				$recentStrikes++;
			}
		}

		return $recentStrikes > 5 ? self::FIFTH_STRIKE : self::FIRST_STRIKE;
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 * @param array $lastStrikes
	 * @param array $newStrike
	 */
	protected function updateLastStrikes(array $lastStrikes, $newStrike): void {
		$thirtyMinutesAgo = $this->time->getTime() - 30 * 60;

		$lastStrikes = array_filter($lastStrikes, function ($strike) use ($thirtyMinutesAgo) {
			return $strike['time'] > $thirtyMinutesAgo;
		});

		array_unshift($lastStrikes, $newStrike);

		$this->config->setUserValue($this->userId, 'ransomware_protection', 'last_strikes', json_encode($lastStrikes));
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 */
	protected function notifyUser(string $path, string $pattern, int $strikeType): void {
		$notification = $this->notifications->createNotification();

		$notification->setApp('ransomware_protection')
			->setDateTime(new \DateTime())
			->setObject('strike', (string)$strikeType)
			->setSubject($strikeType === self::FIRST_STRIKE ? 'upload_blocked' : 'clients_blocked', [
				$path,
				$pattern,
			])
			->setUser($this->userId);
		$this->notifications->notify($notification);
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 * @param string $case
	 * @param string $path
	 * @param string $pattern
	 */
	protected function addStrikeLog($case, $path, $pattern): void {
		$this->logger->warning(
			'Prevented upload of {path} because it matches {case} pattern "{pattern}"',
			[
				'case' => $case,
				'path' => $path,
				'pattern' => $pattern,
				'app' => 'ransomware_protection',
			]
		);
	}

	/**
	 * @psalm-suppress PossiblyUnusedMethod
	 * @param string $case
	 * @param string $path
	 * @param string $pattern
	 * @throws ForbiddenException
	 */
	protected function addRestrikeLog($case, $path, $pattern): void {
		$this->logger->info(
			'Prevented repeated upload of {path} because it matches {case} pattern "{pattern}"',
			[
				'case' => $case,
				'path' => $path,
				'pattern' => $pattern,
				'app' => 'ransomware_protection',
			]
		);
	}
}
