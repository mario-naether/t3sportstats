<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

tx_rnbase::load('tx_rnbase_util_Extensions');

$columns = array(
	'tags' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:t3sportstats/Resources/Private/Language/locallang_db.xml:tx_t3sportstats_tags',
		'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_t3sportstats_tags',
				'size' => 5,
				'autoSizeMax' => 20,
				'minitems' => 0,
				'maxitems' => 100,
				'MM' => 'tx_t3sportstats_tags_mm',
				'MM_match_fields' => Array (
					'tablenames' => 'tx_cfcleague_competition',
				),
				'wizards' => Tx_Rnbase_Utility_TcaTool::getWizards('tx_t3sportstats_tags', array(
					'suggest' => true,
				)
			)
		)
	),
);



tx_rnbase_util_Extensions::addTCAcolumns('tx_cfcleague_competition',$columns,1);
tx_rnbase_util_Extensions::addToAllTCAtypes('tx_cfcleague_competition','tags','','after:point_system');

