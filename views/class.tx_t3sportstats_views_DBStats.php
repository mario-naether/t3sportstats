<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Rene Nitzsche (rene@system25.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(tx_rnbase_util_Extensions::extPath('rn_base') . 'class.tx_rnbase.php');


tx_rnbase::load('tx_rnbase_view_Base');
tx_rnbase::load('tx_rnbase_util_Templates');


/**
 * Viewklasse
 */
class tx_t3sportstats_views_DBStats extends tx_rnbase_view_Base {
	private $playerIds = array();

	/**
	 * 
	 * @param string $template
	 * @param ArrayObject $viewData
	 * @param tx_rnbase_configurations $configurations
	 * @param tx_rnbase_util_FormatUtil $formatter
	 */
	function createOutput($template, &$viewData, &$configurations, &$formatter) {

		$items =& $viewData->offsetGet('items');

		$subpartArr = array();
		foreach($items As $table => $data) {
			$tableMarker = '###'.strtoupper($table).'###';
			$subpart = tx_rnbase_util_Templates::getSubpart($template, $tableMarker);
			// Jetzt die Tabelle rein
			$markerArr = $formatter->getItemMarkerArrayWrapped($data, $this->getController()->getConfId().$table.'.', 0, strtoupper($table).'_');
			$subpartArr[$tableMarker] = tx_rnbase_util_Templates::substituteMarkerArrayCached($subpart, $markerArr);
		}
		$out = tx_rnbase_util_Templates::substituteMarkerArrayCached($template, array(), $subpartArr);
		return $out;
	}

	/**
	 * Subpart der im HTML-Template geladen werden soll. Dieser wird der Methode
	 * createOutput automatisch als $template übergeben. 
	 *
	 * @return string
	 */
	function getMainSubpart() {
		return '###DBSTATS###';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/views/class.tx_t3sportstats_views_DBStats.php']){
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/views/class.tx_t3sportstats_views_DBStats.php']);
}
?>