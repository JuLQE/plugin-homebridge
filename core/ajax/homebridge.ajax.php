<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

header('Content-Type: application/json');

try {
	require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
	include_file('core', 'authentification', 'php');

	if (!isConnect('admin')) {
		throw new Exception(__('401 - Accès non autorisé', __FILE__));
	}

	if (init('action') == 'repairHomebridge'){
		$ret=homebridge::repairHomebridge(false);
		ajax::success($ret);
	}
	if (init('action') == 'repairHomebridge_reinstall'){
		$ret=homebridge::repairHomebridge(true);
		ajax::success($ret);
	}
	
	if (init('action') == 'regenerateHomebridgeConf') {
		homebridge::generate_file();
		ajax::success();
	}
	if (init('action') == 'getJSON') {
		$file = homebridge::getJSON();
		ajax::success($file);
	}
	if (init('action') == 'saveJSON') {
		$ret = homebridge::saveJSON(init('file'));
		ajax::success($ret);
	}
	throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));

} catch (Exception $e) {
	ajax::error(displayExeption($e), $e->getCode());
}
?>
