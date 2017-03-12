<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$tx_t3sportstats_tags = Array (
	'ctrl' => Array (
			'title' => 'LLL:EXT:t3sportstats/Resources/Private/Language/locallang_db.xml:tx_t3sportstats_tags',
			'label' => 'name',
			'searchFields' => 'uid,name,label',
			'tstamp' => 'tstamp',
			'crdate' => 'crdate',
			'cruser_id' => 'cruser_id',
			'dividers2tabs' => TRUE,
			'default_sortby' => 'ORDER BY name',
			'delete' => 'deleted',
			'enablecolumns' => Array (
			),
			'iconfile' => tx_rnbase_util_Extensions::extRelPath('cfc_league').'Resources/Public/Icons/icon_table.gif',
	),
	'interface' => Array (
			'showRecordFieldList' => 'name'
	),
	'feInterface' => Array (
			'fe_admin_fieldList' => 'hidden, starttime, fe_group, name',
	),
	'columns' => Array (
			'name' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3sportstats/Resources/Private/Language/locallang_db.xml:tx_t3sportstats_tags_name',
					'config' => Array (
							'type' => 'input',
							'size' => '30',
							'max' => '50',
							'eval' => 'required,trim',
							)
					),
			'label' => Array (
					'exclude' => 1,
					'label' => 'LLL:EXT:t3sportstats/Resources/Private/Language/locallang_db.xml:tx_t3sportstats_tags_label',
					'config' => Array (
							'type' => 'input',
							'size' => '30',
							'max' => '50',
							'eval' => 'required,trim',
							)
					),
	),
	'types' => Array (
			'0' => Array('showitem' => 'name,label')
	),
	'palettes' => Array (
			'1' => Array('showitem' => '')
	)
);

return $tx_t3sportstats_tags;
