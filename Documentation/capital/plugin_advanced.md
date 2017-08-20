# Erweiterte Möglichkeiten zum Plugin
## Eigene Report-Profile erstellen

Für alle Personenstatistiken gibt es einen vorbereiteten Report, der einen Gesamtstatistik
vorbereitet. Bei den Spielern gibt es zusätzliche Reports für Torschützen und Torvorbereiter.

Weitere Reports kann man leicht selber integrieren. Dazu muss man sich zunächst eine eigene 
Extension erstellen und in TYPO3 registrieren.

Der eigene Report benötigt zunächst einen eindeutigen eigenen Identifier. Für die 
Torschützenliste wird die ID *scorerlist* verwendet. In der Datei ext_localconf.php wird diese
ID registriert:
```php
tx_t3sportstats_util_Config::registerPlayerStatsReport('scorerlist');
```
Nach Löschen des System-Caches sollte diese ID direkt im Plugin von *T3sportstats* mit angezeigt 
werden.

Die eigentliche Konfiguration des Reports erfolgt nun per Typoscript. Für die Torschützenliste 
wurde folgendes Typoscript erstellt:
```
plugin.tx_t3sportstats {
  playerstats {
    # Den Standardfilter für die Spieler übernehmen
    scorerlist =< lib.t3sports.statsPlayerFilter
    scorerlist {
      # Die Ergebnisliste soll absteigend nach der Anzahl Tore sortiert werden
      options.orderby.CUSTOM = goals desc
      # Nur Treffer mit wenigstens einem Tor anzeigen
    	options.having = sum(goals) > 0
    	# die Konfiguration für die Formatierung der Daten im Frontend übernehmen
      data =< lib.t3sports.statsData
    }
  }
}
```
Jetzt muss nur noch ein Subpart für die Ausgabe der Daten angelegt werden. Der Hauptsubpart für die 
Spielerstatistiken heißt `###PLAYERSTATS###`. Innerhalb dieses Templates werden vom Plugin weitere 
Subparts für die Reports erwartet. Diese müssen genauso genannt werden, wie die Report-ID, nur in 
Großschreibweise. Für die Torschützen also `###SCORERLIST###`. So kann ein einfaches Beispiel aussehen:
```
###SCORERLIST###

###DATAS###
<ul>
###DATA###
<li>###DATA_PLAYER_DCNAMEREV### (###DATA_GOALS###/###DATA_GOALS_PER_MATCH###)</li>
###DATA###
<ul>
###DATAS###

###SCORERLIST###
```
