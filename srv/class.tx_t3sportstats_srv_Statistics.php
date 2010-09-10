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
require_once(PATH_t3lib.'class.t3lib_svbase.php');


/**
 * Service for accessing team information
 * 
 * @author Rene Nitzsche
 */
class tx_t3sportstats_srv_Statistics extends t3lib_svbase {

	/**
	 * Update statistics for a competition
	 *
	 * @param tx_cfcleague_models_Competition $competition
	 */
	public function indexPlayerStatsByCompetition($competition, $options) {
		// Der Service lädt alle DatenServices für Spielerdaten
		// Danach lädt er die Spiele eines Wettbewerbs
		// Für jedes Spiel werden die Events geladen
		// Anschließend bekommt jeder Service das Spiel, den Spieler und die Events übergeben
		// In ein Datenarray legt er die relevanten Daten für den Spieler
		$mSrv = tx_cfcleague_util_ServiceRegistry::getMatchService();
		$builder = $mSrv->getMatchTableBuilder();
		$builder->setCompetitions($competition->getUid());
		$builder->setStatus(2);
		$builder->getFields($fields, $options);
		$matches = $mSrv->search($fields, $options);
		$this->indexPlayerStatsByMatches($matches, false);
	}
	/**
	 * Returns all registered services for player statistics
	 * @return array
	 */
	public function lookupPlayerServices() {
		$srvArr = tx_rnbase_util_Misc::lookupServices('t3sportsPlayerStats');
		$ret = array();
		foreach($srvArr As $subType => $srvData) {
			$ret[] = tx_rnbase_util_Misc::getService('t3sportsPlayerStats', $subType);
		}
		return $ret;
	}
	public function indexPlayerStatsByMatches($matches, $options) {
		// Services laden
		$servicesArr = $this->lookupPlayerServices();

		// Über alle Spiele iterieren und die Spieler an die Services geben
		for($j=0, $mc = count($matches); $j < $mc; $j++){
			$matchNotes = tx_cfcleague_util_ServiceRegistry::getMatchService()->retrieveMatchNotes($matches[$j], true);
			$mnProv = tx_t3sportstats_util_MatchNoteProvider::createInstance($matchNotes);
			for($i=0, $servicesArrCnt=count($servicesArr); $i < $servicesArrCnt; $i++) {
				$service =& $servicesArr[$i];
				// handle Hometeam
				$dataBags = $this->getPlayerBags($matches[$j], true);
				foreach($dataBags As $dataBag) {
					$service->indexPlayerStats($dataBag, $matches[$j], $mnProv);
				}
				// handle Guestteam
				$dataBags = $this->getPlayerBags($matches[$j], false);
				foreach($dataBags As $dataBag) {
					$service->indexPlayerStats($dataBag, $matches[$j], $matchNotes);
				}

//				$times[$i] = $times[$i] + t3lib_div::milliseconds() - $time;
			}
		}
	}

	/**
	 * Liefert die DataBags für die Spieler eines beteiligten Teams.
	 *
	 * @param tx_cfcleaguefe_models_match $match
	 * @param boolean $home true, wenn das Heimteam geholt werden soll
	 * @return array[tx_t3sportstats_util_DataBag]
	 */
	public function getPlayerBags($match, $home) {
		$type = $home ? 'home' : 'guest';
		$ids = $match->record['players_'.$type];
		if(strlen($match->record['substitutes_'.$type]) > 0){
			// Auch Ersatzspieler anhängen
			if(strlen($ids) > 0) $ids .= ',' . $match->record['substitutes_'.$type];
			else $ids = $match->record['substitutes_'.$type];
		}
		$bags = array();
		$playerIds = t3lib_div::intExplode(',', $ids);
		foreach($playerIds As $uid) {
			$bag = tx_rnbase::makeInstance('tx_t3sportstats_util_DataBag');
			$bag->setParentUid($uid);
			$bags[] = $bag;
		}
		return $bags;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/srv/class.tx_t3sportstats_srv_Statistics.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/srv/class.tx_t3sportstats_srv_Statistics.php']);
}

?>