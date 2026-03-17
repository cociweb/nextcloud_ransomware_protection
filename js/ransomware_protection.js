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

$(function() {
	$('#ransomware_protection_reenable').on('click', function() {
		$.ajax({
			type: 'POST',
			url: OC.linkToOCS('apps/ransomware_protection/api/v1', 2) + 'protection'
		})
		.done(function() {
			$('#ransomware_protection_paused').addClass('hidden');
			$('#ransomware_protection_protected').removeClass('hidden');
		})
		.fail(function(xhr, status, error) {
			console.error('Failed to re-enable protection:', error);
		});
	});
});
