
#
# Table structure for table 'tx_t3sportstats_players'
# Statistic data of player per match
#
CREATE TABLE tx_t3sportstats_players (
	uid int(11) NOT NULL auto_increment,
	crdate datetime DEFAULT '0000-00-00 00:00:00',

	player int(11) DEFAULT '0' NOT NULL,
	t3match int(11) DEFAULT '0' NOT NULL,
	saison int(11) DEFAULT '0' NOT NULL,
	competition int(11) DEFAULT '0' NOT NULL,
	agegroup int(11) DEFAULT '0' NOT NULL,
	team int(11) DEFAULT '0' NOT NULL,
	club int(11) DEFAULT '0' NOT NULL,
	ishome tinyint(4)  DEFAULT '0' NOT NULL,
	agegroupopp int(11) DEFAULT '0' NOT NULL,
	clubopp int(11) DEFAULT '0' NOT NULL,


	played tinyint(4) DEFAULT '0' NOT NULL,
	cardyellow tinyint(4) DEFAULT '0' NOT NULL,
	cardyr tinyint(4) DEFAULT '0' NOT NULL,
	cardred tinyint(4) DEFAULT '0' NOT NULL,
	playtime int(11) DEFAULT '0' NOT NULL,
	goals int(11) DEFAULT '0' NOT NULL,
	assists int(11) DEFAULT '0' NOT NULL,
	goalshome int(11) DEFAULT '0' NOT NULL,
	goalsaway int(11) DEFAULT '0' NOT NULL,
	goalshead int(11) DEFAULT '0' NOT NULL,
	goalsfreekick int(11) DEFAULT '0' NOT NULL,
	goalspenalty int(11) DEFAULT '0' NOT NULL,
	goalsjoker int(11) DEFAULT '0' NOT NULL,
	changein int(11) DEFAULT '0' NOT NULL,
	changeout int(11) DEFAULT '0' NOT NULL,


	PRIMARY KEY (uid),
	KEY playmatch (player, t3match)
);

#
# Table structure for table 'tx_t3sportstats_players'
# Scope data for a match
#
/*
CREATE TABLE tx_t3sportstats_matchs (
	uid int(11) NOT NULL auto_increment,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,

	t3match int(11) DEFAULT '0' NOT NULL,
	competition int(11) DEFAULT '0' NOT NULL,
	saison int(11) DEFAULT '0' NOT NULL,
	group int(11) DEFAULT '0' NOT NULL,

	round int(11) DEFAULT '0' NOT NULL,
	round_name varchar(100) DEFAULT '' NOT NULL,

	betgame int(11) DEFAULT '0' NOT NULL,
	status tinyint(4) DEFAULT '0' NOT NULL,
	teamquestions int(11) DEFAULT '0' NOT NULL,
	comment text NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);
*/
