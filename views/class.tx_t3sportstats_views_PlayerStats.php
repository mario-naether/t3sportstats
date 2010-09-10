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

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');


tx_rnbase::load('tx_rnbase_view_Base');
tx_rnbase::load('tx_rnbase_util_Templates');


/**
 * Viewklasse für die Darstellung von Nutzerinformationen aus der DB
 */
class tx_t3sportstats_views_PlayerStats extends tx_rnbase_view_Base {

  function createOutput($template, &$viewData, &$configurations, &$formatter) {
  	// Wir holen die Daten von der Action ab
    $data =& $viewData->offsetGet('data');
    
    // Das Array jetzt als Markerarray aufbereiten
    // Durch Verwendung dieser Funktion können wir alle Daten automatisch auch per 
    // stdWrap mit Typoscript konfigurieren!
    // Parameter:
    // 1. Das Array mit den Daten (immer nur Key-Value, keine verschachtelten Arrays verwenden!)
    // 2. Typoscript-Pfad für die Formatierung. Die einzelnen Daten werden dann über ihren
    //    Namen angesprochen: showusersummary.total.wrap = <b>|</b>
    // 3. uninteressant
    // 4. ein Marker-Prefix. Wenn 'BLA_' wird aus ###TOTAL### der Marker ###BLA_TOTAL###
    // 5. Array mit Namen von Markern. Diese werden dann immer leer angelegt. (uninteressant)
    $markerArray = $formatter->getItemMarkerArrayWrapped($data, 'showusersummary.' , 0, '',null);
		$out = tx_rnbase_util_Templates::substituteMarkerArrayCached($template, $markerArray);

		return $out;
  }

  /**
   * Subpart der im HTML-Template geladen werden soll. Dieser wird der Methode
   * createOutput automatisch als $template übergeben. 
   *
   * @return string
   */
  function getMainSubpart() {
  	return '###SHOWUSERSUMMARY###';
  }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/views/class.tx_t3sportstats_views_PlayerStats.php']){
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/views/class.tx_t3sportstats_views_PlayerStats.php']);
}
?>