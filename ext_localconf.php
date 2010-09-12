<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');
tx_rnbase::load('tx_t3sportstats_util_ServiceRegistry');
tx_rnbase::load('tx_rnbase_util_SearchBase');


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

tx_rnbase::load('tx_t3sportstats_util_Config');

tx_t3sportstats_util_Config::registerSimpleStatistics('goals', '10,11,12');
tx_t3sportstats_util_Config::registerSimpleStatistics('assists', '31');
tx_t3sportstats_util_Config::registerSimpleStatistics('goalsheader', '11');
tx_t3sportstats_util_Config::registerSimpleStatistics('goalspenalty', '12');
tx_t3sportstats_util_Config::registerSimpleStatistics('goalsown', '30');
tx_t3sportstats_util_Config::registerSimpleStatistics('cardyellow', '70');
tx_t3sportstats_util_Config::registerSimpleStatistics('cardyr', '71');
tx_t3sportstats_util_Config::registerSimpleStatistics('cardred', '72');
tx_t3sportstats_util_Config::registerSimpleStatistics('changeout', '80');
tx_t3sportstats_util_Config::registerSimpleStatistics('changein', '81');

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