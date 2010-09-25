<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');
tx_rnbase::load('tx_t3sportstats_util_ServiceRegistry');
tx_rnbase::load('tx_rnbase_util_SearchBase');

$GLOBALS ['TYPO3_CONF_VARS']['EXTCONF']['cfc_league']['clearStatistics_hook'][] = 'EXT:' . $_EXTKEY . '/hooks/class.tx_t3sportstats_hooks_ClearStats.php:&tx_t3sportstats_hooks_ClearStats->clearStats4Comp';

// Hook for match search
$GLOBALS ['TYPO3_CONF_VARS']['EXTCONF']['cfc_league_fe']['search_Match_getTableMapping_hook'][] = 'EXT:' . $_EXTKEY . '/hooks/class.tx_t3sportstats_hooks_Search.php:&tx_t3sportstats_hooks_Search->getTableMappingMatch';
$GLOBALS ['TYPO3_CONF_VARS']['EXTCONF']['cfc_league_fe']['search_Match_getJoins_hook'][] = 'EXT:' . $_EXTKEY . '/hooks/class.tx_t3sportstats_hooks_Search.php:&tx_t3sportstats_hooks_Search->getJoinsMatch';

// Hook for profile marker
$GLOBALS ['TYPO3_CONF_VARS']['EXTCONF']['cfc_league_fe']['profileMarker_afterSubst'][] = 'EXT:' . $_EXTKEY . '/hooks/class.tx_t3sportstats_hooks_Marker.php:&tx_t3sportstats_hooks_Marker->parseProfile';

t3lib_extMgm::addService($_EXTKEY,  't3sportstats' /* sv type */,  'tx_t3sportstats_srv_Statistics' /* sv key */,
  array(
    'title' => 'LLL:EXT:t3sportstats/locallang_db.xml:service_t3sports_statistics_title', 'description' => 'Statistical data about T3sports', 'subtype' => 'statistics',
    'available' => TRUE, 'priority' => 50, 'quality' => 50,
    'os' => '', 'exec' => '',
    'classFile' => t3lib_extMgm::extPath($_EXTKEY).'srv/class.tx_t3sportstats_srv_Statistics.php',
    'className' => 'tx_t3sportstats_srv_Statistics',
  )
);


t3lib_extMgm::addService($_EXTKEY,  't3sportsPlayerStats' /* sv type */,  'tx_t3sportstats_srv_PlayerStats' /* sv key */,
  array(
    'title' => 'LLL:EXT:t3sportstats/locallang_db.xml:service_t3sports_playerstats_title', 'description' => 'Statistical data about players', 'subtype' => 'base',
    'available' => TRUE, 'priority' => 50, 'quality' => 50,
    'os' => '', 'exec' => '',
    'classFile' => t3lib_extMgm::extPath($_EXTKEY).'srv/class.tx_t3sportstats_srv_PlayerStats.php',
    'className' => 'tx_t3sportstats_srv_PlayerStats',
  )
);

t3lib_extMgm::addService($_EXTKEY,  't3sportsPlayerStats' /* sv type */,  'tx_t3sportstats_srv_PlayerTimeStats' /* sv key */,
  array(
    'title' => 'LLL:EXT:t3sportstats/locallang_db.xml:service_t3sports_playertimestats_title', 'description' => 'Statistical data about players', 'subtype' => 'playtime',
    'available' => TRUE, 'priority' => 50, 'quality' => 50,
    'os' => '', 'exec' => '',
    'classFile' => t3lib_extMgm::extPath($_EXTKEY).'srv/class.tx_t3sportstats_srv_PlayerTimeStats.php',
    'className' => 'tx_t3sportstats_srv_PlayerTimeStats',
  )
);

t3lib_extMgm::addService($_EXTKEY,  't3sportsPlayerStats' /* sv type */,  'tx_t3sportstats_srv_PlayerGoalStats' /* sv key */,
  array(
    'title' => 'LLL:EXT:t3sportstats/locallang_db.xml:service_t3sports_playertimestats_title', 'description' => 'Statistical data about players', 'subtype' => 'goals',
    'available' => TRUE, 'priority' => 50, 'quality' => 50,
    'os' => '', 'exec' => '',
    'classFile' => t3lib_extMgm::extPath($_EXTKEY).'srv/class.tx_t3sportstats_srv_PlayerGoalStats.php',
    'className' => 'tx_t3sportstats_srv_PlayerGoalStats',
  )
);

// Register a new matchnote type
tx_rnbase::load('tx_cfcleague_util_Misc');
tx_cfcleague_util_Misc::registerMatchNote('LLL:EXT:t3sportstats/locallang_db.xml:tx_cfcleague_match_notes.type.goalfreekick', '13');

tx_rnbase::load('tx_t3sportstats_util_Config');

tx_t3sportstats_util_Config::registerPlayerStatsSimple('goals', '10,11,12,13');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('assists', '31');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('goalshead', '11');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('goalspenalty', '12');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('goalsown', '30');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('cardyellow', '70');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('cardyr', '71');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('cardred', '72');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('changeout', '80');
tx_t3sportstats_util_Config::registerPlayerStatsSimple('changein', '81');

tx_t3sportstats_util_Config::registerPlayerStatsReport('default');
tx_t3sportstats_util_Config::registerPlayerStatsReport('scorerlist');
tx_t3sportstats_util_Config::registerPlayerStatsReport('assistlist');

/*
$GLOBALS ['TYPO3_CONF_VARS']['EXTCONF']['cfc_league']['matchnotetypes'] = array(
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.ticker', '100'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.goal', '10'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.goal.header', '11'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.goal.penalty', '12'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.goal.own', '30'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.goal.assist', '31'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.penalty.forgiven', '32'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.corner', '33'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.yellow', '70'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.yellowred', '71'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.red', '72'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.changeout', '80'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.changein', '81'),
			Array('LLL:EXT:cfc_league/locallang_db.xml:tx_cfcleague_match_notes.type.captain', '200'),
);
*/
?>