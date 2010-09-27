<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Rene Nitzsche
 *  Contact: rene@system25.de
 *  All rights reserved
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 ***************************************************************/

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');


/**
 * Make additional join for match search 
 * 
 * @author Rene Nitzsche
 */
class tx_t3sportstats_hooks_Search {

	public function getTableMappingMatch($params, $parent) {
		$params['tableMapping']['PLAYERSTATS'] = 'tx_t3sportstats_players';
	}
	public function getJoinsMatch($params, $parent) {
		if(isset($params['tableAliases']['PLAYERSTATS'])) {
			$params['join'] .= ' JOIN tx_t3sportstats_players ON tx_cfcleague_games.uid = tx_t3sportstats_players.t3match ';
		}
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/hooks/class.tx_t3sportstats_hooks_Search.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/t3sportstats/hooks/class.tx_t3sportstats_hooks_Search.php']);
}

?>