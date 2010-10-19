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

tx_rnbase::load('tx_rnbase_model_base');

/**
 * Model for a coach stats record.
 */
class tx_t3sportstats_models_CoachStat extends tx_rnbase_model_base {
	private static $instances = array();

	function getTableName(){return 'tx_t3sportstats_coachs';}

	/**
	 * Returns the competition uid
	 *
	 * @return int
	 */
	public function getCompetitionUid() {
		return $this->record['competition'];
	}
	public function getMatchUid() {
		return $this->record['t3match'];
	}
	/**
	 * Returns the club
	 *
	 * @return int
	 */
	public function getClubUid() {
		return $this->record['club'];
	}
	/**
	 * Returns the opponent club uid.
	 *
	 * @return int
	 */
	public function getClubOppUid() {
		return $this->record['clubopp'];
	}
	/**
	 * Returns the player uid.
	 *
	 * @return int
	 */
	public function getCoachUid() {
		return $this->record['coach'];
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/models/class.tx_t3sportstats_models_CoachStat.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/models/class.tx_t3sportstats_models_CoachStat.php']);
}

?>