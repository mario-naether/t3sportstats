<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007-2010 Rene Nitzsche (rene@system25.de)
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

tx_rnbase::load('tx_rnbase_util_BaseMarker');
tx_rnbase::load('tx_cfcleague_models_Profile');



/**
 * Diese Klasse ist für die Erstellung von Markerarrays für Spiele verantwortlich
 */
class tx_t3sportstats_marker_PlayerStats extends tx_rnbase_util_BaseMarker {

  /**
   * @param $template das HTML-Template
   * @param tx_cfcleaguefe_models_match $match das Spiel
   * @param tx_rnbase_util_FormatUtil $formatter der zu verwendente Formatter
   * @param $confId Pfad der TS-Config des Spiels, z.B. 'listView.match.'
   * @param $marker Name des Markers für ein Spiel, z.B. MATCH
   * @return String das geparste Template
   */
	public function parseTemplate($template, $item, &$formatter, $confId, $marker = 'MATCH') {
		if(!is_object($item)) {
			return $formatter->configurations->getLL('item_notFound');
		}
//$time = t3lib_div::milliseconds();

		$this->prepareFields($item, $template, $marker);
		tx_rnbase_util_Misc::callHook('t3sportstats','playerStatsMarker_initRecord', 
			array('item' => &$item, 'template'=>&$template, 'confid'=>$confId, 'marker'=>$marker, 'formatter'=>$formatter), $this);

		// Das Markerarray wird gefüllt
		$ignore = self::findUnusedCols($item->record, $template, $marker);
		$markerArray = $formatter->getItemMarkerArrayWrapped($item->record, $confId, $ignore, $marker.'_');
		$wrappedSubpartArray = array();
		$subpartArray = array();

		$this->prepareLinks($item, $marker, $markerArray, $subpartArray, $wrappedSubpartArray, $confId, $formatter, $template);
		// Es wird jetzt das Template verändert und die Daten der Teams eingetragen

		if($this->containsMarker($template, $marker.'_PLAYER_'))
			$template = $this->_addPlayer($template, $item, $formatter, $confId.'player.', $marker.'_PLAYER');

		$template = tx_rnbase_util_Templates::substituteMarkerArrayCached($template, $markerArray, $subpartArray, $wrappedSubpartArray);
		tx_rnbase_util_Misc::callHook('t3sportstats','playerStatsMarker_afterSubst', 
			array('item' => &$item, 'template'=>&$template, 'confid'=>$confId, 'marker'=>$marker, 'formatter'=>$formatter), $this);
		return $template;
	}

	/**
	 * Bindet den Spieler ein
	 *
	 * @param string $template
	 * @param tx_t3sportstats_models_PlayerStat $item
	 * @param tx_rnbase_util_FormatUtil $formatter
	 * @param string $confId
	 * @param string $markerPrefix
	 * @return string
	 */
	protected function _addPlayer($template, &$item, &$formatter, $confId, $markerPrefix) {
		$sub = $item->getPlayerUid();
		if(!$sub) {
			// Kein Stadium vorhanden. Leere Instanz anlegen und altname setzen
			$sub = tx_rnbase_util_BaseMarker::getEmptyInstance('tx_cfcleague_models_Profile');
		}
		else	$sub = tx_cfcleague_models_Profile::getInstance($sub);
		$marker = tx_rnbase::makeInstance('tx_cfcleaguefe_util_ProfileMarker');
		$template = $marker->parseTemplate($template, $sub, $formatter, $confId, $markerPrefix);
		return $template;
	}

	/**
	 * Im folgenden werden einige Personenlisten per TS aufbereitet. Jede dieser Listen 
	 * ist über einen einzelnen Marker im FE verfügbar. Bei der Ausgabe der Personen
	 * werden auch vorhandene MatchNotes berücksichtigt, so daß ein Spieler mit gelber 
	 * Karte diese z.B. neben seinem Namen angezeigt bekommt.
	 *
	 * @param tx_t3sportstats_models_PlayerStat $item
	 */
	private function prepareFields($item, $template, $markerPrefix) {
		$perMatch = array();
		foreach($item->record As $key => $value) {
			if(self::containsMarker($template, $markerPrefix.'_'.strtoupper($key).'_PER_MATCH')) {
				$perMatch[$key.'_per_match'] = intval($item->record['played']) ? 
						intval($item->record[$key]) / intval($item->record['played']) : 0;
			}
			if(self::containsMarker($template, $markerPrefix.'_'.strtoupper($key).'_AFTER_MINUTES')) {
				$perMatch[$key.'_after_minutes'] = (intval($item->record[$key])) ? 
					 intval($item->record['playtime']) / intval($item->record[$key]) : 0;
				
			}
		}
		$item->record = array_merge($item->record, $perMatch);
		
	}

	/**
	 * Links vorbereiten
	 *
	 * @param tx_t3sportstats_models_PlayerStat $item
	 * @param string $marker
	 * @param array $markerArray
	 * @param array $wrappedSubpartArray
	 * @param string $confId
	 * @param tx_rnbase_util_FormatUtil $formatter
	 */
	private function prepareLinks($item, $marker, &$markerArray, &$subpartArray, &$wrappedSubpartArray, $confId, &$formatter, $template) {
		// Verlinkung auf Spielplan mit den Spielen der aktuellen Auswertung
		$linkNames = $formatter->getConfigurations()->getKeyNames($confId.'links.');
		foreach($linkNames As $linkId) {
			if($item->record[$linkId]) {
				// Link nur bei Wert größer 0 ausführen, damit keine leere Liste verlinkt wird.
				$params = array('statskey' => $linkId, 'player'=>$item->record['player']);
				$this->initLink($markerArray, $subpartArray, $wrappedSubpartArray, $formatter, $confId, $linkId, $marker, $params, $template);
			}
			else {
				$linkMarker = $marker . '_' . strtoupper($linkId).'LINK';
				$remove = intval($formatter->configurations->get($confId.'links.'.$linkId.'.removeIfDisabled'));
				$this->disableLink($markerArray, $subpartArray, $wrappedSubpartArray, $linkMarker, $remove > 0);
			}
		}

	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/marker/class.tx_t3sportstats_marker_PlayerStats.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/marker/class.tx_t3sportstats_marker_PlayerStats.php']);
}
?>