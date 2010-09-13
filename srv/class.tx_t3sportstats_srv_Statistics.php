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
tx_rnbase::load('tx_rnbase_util_Logger');
tx_rnbase::load('tx_rnbase_util_Dates');
tx_rnbase::load('tx_t3sportstats_util_MatchNoteProvider');



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
	public function indexPlayerStatsByCompetition($competition) {
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
		$this->indexPlayerStatsByMatches($matches);
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
	public function indexPlayerStatsByMatches($matches) {
		// Services laden
		$servicesArr = $this->lookupPlayerServices();

		tx_rnbase_util_Logger::info('Start player statistics run for ' . count($matches) . ' matches.', 't3sportstats');

		// Über alle Spiele iterieren und die Spieler an die Services geben
		for($j=0, $mc = count($matches); $j < $mc; $j++){
			$matchNotes = tx_cfcleague_util_ServiceRegistry::getMatchService()->retrieveMatchNotes($matches[$j], true);
			$mnProv = tx_t3sportstats_util_MatchNoteProvider::createInstance($matchNotes);
			// handle Hometeam
			$this->indexPlayerData($matches[$j], $mnProv, $servicesArr, true);
			// handle Guestteam
			$this->indexPlayerData($matches[$j], $mnProv, $servicesArr, false);
		}
	}
	/**
	 * Indizierung der Daten und Speicherung in der DB
	 * @param tx_cfcleague_models_Match $match
	 * @param tx_t3sportstats_util_MatchNoteProvider $mnProv
	 * @param boolean $homeTeam
	 */
	private function indexPlayerData($match, $mnProv, $servicesArr, $homeTeam) {
		$del = $this->clearPlayerData($match);
		tx_rnbase_util_Logger::debug('Player statistics: ' . $del . ' old records deleted.', 't3sportstats');
		
		$dataBags = $this->getPlayerBags($match, $homeTeam);
		for($i=0, $servicesArrCnt=count($servicesArr); $i < $servicesArrCnt; $i++) {
			$service =& $servicesArr[$i];
			foreach($dataBags As $dataBag) {
				$service->indexPlayerStats($dataBag, $match, $mnProv, $homeTeam);
			}
		}
		// Jetzt die Daten wegspeichern
		$this->savePlayerData($dataBags);
		unset($dataBags);
	}

	/**
	 * Delete all player data in database for a match
	 * @param tx_cfcleague_models_Match $match
	 */
	private function clearPlayerData($match) {
		$where = 't3match = ' . $match->getUid();
		return tx_rnbase_util_DB::doDelete('tx_t3sportstats_players', $where);
	}
	private function savePlayerData($dataBags) {
		$now = tx_rnbase_util_Dates::datetime_tstamp2mysql(time());
		foreach($dataBags As $dataBag) {
			$data = $dataBag->getTypeValues();
			$data['crdate'] = $now;
			tx_rnbase_util_DB::doInsert('tx_t3sportstats_players', $data);
		}
	}
	/**
	 * Liefert die DataBags für die Spieler eines beteiligten Teams.
	 *
	 * @param tx_cfcleague_models_Match $match
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
			// Hier noch die allgemeinen Daten rein!
			$bag->setType('t3match', $match->getUid());
			$bag->setType('player', $uid);
			$competition = $match->getCompetition();
			$bag->setType('saison', $competition->getSaisonUid());
			// Altersgruppe ist zunächst die AG des Teams, danach die des Wettbewerbs
			$team = $home ? $match->getHome() : $match->getGuest();
			$groupUid = $this->getGroupUid($team, $competition);
			$bag->setType('agegroup', $groupUid);
			$bag->setType('team', $team->getUid());
			$bag->setType('club', $team->getClubUid());
			$bag->setType('ishome', $home ? 1 : 0);

			$team = $home ? $match->getGuest() : $match->getHome();
			$groupUid = $this->getGroupUid($team, $competition);
			$bag->setType('agegroupopp', $groupUid);
			$bag->setType('clubopp', $team->getClubUid());

			$bags[] = $bag;
		}
		return $bags;
	}
	private function getGroupUid($team, $competition) {
		$groupUid = $team->getGroupUid();
		if(!$groupUid) {
			$groupUid = $competition->getFirstGroupUid();
		}
		return $groupUid;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/srv/class.tx_t3sportstats_srv_Statistics.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/srv/class.tx_t3sportstats_srv_Statistics.php']);
}

?>