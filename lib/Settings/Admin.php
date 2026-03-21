<?php

/**
 * @copyright Copyright (c) 2017 Joas Schilling <coding@schilljs.com>
 *
 * @author Joas Schilling <coding@schilljs.com>
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

namespace OCA\RansomwareProtection\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

/**
 * @psalm-suppress UnusedClass
 */
class Admin implements ISettings {

	/** @var IConfig */
	protected $config;

	/**
	 * @param IConfig $config
	 */
	public function __construct(IConfig $config) {
		$this->config = $config;
	}

	#[\Override]
	public function getForm(): TemplateResponse {
		return new TemplateResponse('ransomware_protection', 'admin', [
			'notesIncludeBiased' => $this->config->getAppValue('ransomware_protection', 'notes_include_biased', 'no') === 'yes',
			'extensionAdditions' => $this->getCustomList('extension_additions'),
			'noteFileAdditions' => $this->getCustomList('notefile_additions'),
			'extensionExclusions' => $this->getCustomList('extension_exclusions'),
			'noteFileExclusions' => $this->getCustomList('notefile_exclusions'),
		], '');
	}

	protected function getCustomList(string $list): string {
		$config = $this->config->getAppValue('ransomware_protection', $list, '[]');
		$data = json_decode($config, true);
		return implode("\n", $data);
	}

	#[\Override]
	public function getSection(): string {
		return 'security';
	}

	#[\Override]
	public function getPriority(): int {
		return 1;
	}
}
