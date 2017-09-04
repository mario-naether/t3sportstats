# Features
Die Extension stellt derzeit Informationen zu Spielern, Trainern und Schiedsrichtern bereit. Die Auswertung kann
immer über unterschiedliche Datenbereiche durchgeführt werden. Man kann also einzelne Wettbewerbe genauso auswerten,
wie eine Gruppe von Wettbewerben oder auch den gesamten Datenbestand.

Die Anzeige kann zum einen natürlich als Gesamtstatistik erfolgen. Das heißt, man listet zum Beispiel die Daten
aller Spieler eines Wettbewerbs in einer Tabelle auf. Dafür kann man die Views des Plugins von T3sports verwenden. 
Zusätzlich ist es aber auch möglich, die Detailansicht von Personen aus T3sports zu erweitern. Das Plugin registriert 
einen Hook und zeigt damit statistische Informationen zu einem Spieler in dessen Detailansicht an. Das funktioniert 
natürlich auch für die Trainer und Schiedsrichter.

Bei Trainern und Spielern kann die Statistik immer aus zwei Blickwinkeln integriert werden. Man kann die Daten für den
eigene Verein anzeigen. Man kann aber zeigen, welche Werte der Spieler für andere Vereine gegen den eigenen Verein 
erreicht hat.

Sehr interessant ist auch die Integration in die Spielplan-Ansicht von *T3sports*. Man kann praktisch jeden in der 
Statistik ermittelten Wert, mit einem Spielplan verlinken, in dem genau die betroffenen Spiele aufgelistet werden.
Wenn ein Spieler also in zwei Spielen drei Tore geschossen hat, dann kann man eine Spielplan mit diesen beiden Spielen
erzeugen lassen.

## Spieler
Für Spieler werden folgende Informationen gesammelt.

* Anzahl Spiele
* Gelbe Karten
* Gelb-rote Karten
* Rote Karten
* Spielminuten
* Tore gesamt
* Tore bei Heimspielen
* Tore bei Auswärtspielen
* Tore per Kopf
* Freistoßtore
* Eigentore
* Tore per Elfmeter
* Tore als Joker
* Eigentore
* Einwechslungen
* Auswechslungen
* Siege
* Unentschieden
* Niederlagen
* Spiele als Mannschaftskapitän

Bei vielen Daten müssen natürlich die entsprechenden Spielinformationen (Tickerfunktion in T3sports) gepflegt werden.
In der Statistik werden die meisten Daten dann summiert, als auch als Durchschnittswert bereitgestellt. Alle Berechnungen 
können per Typoscript angepasst oder erweitert werden. Speziell für die Spieler sind neben einer Gesamtstatistik, noch 
Spezialausgaben für Torjäger und Torvorbereiter vorhanden.

## Trainer
Für Trainer werden die folgenden Daten erfasst und ausgewertet:

* Anzahl Spiele
* Siege
* Unentschieden
* Niederlagen
* Tore
* Tore bei Heimspielen
* Tore bei Auswärtspielen
* Tore durch Joker
* Gegentore
* Gegentore bei Heimspielen
* Gegentore bei Auswärtspielen
* Gelbe Karten
* Gelb-rote Karten
* Rote Karten
* Anzahl Spielerwechsel

# Schiedsrichter
Bei den Schiedsrichtern ist zu beachten, daß die Daten pro Spiel zweimal erfasst werden. Einmal aus Sicht des Heimteams
und einmal für den Gastverein. Die folgenden Daten werden erfasst und ausgewertet:

* Anzahl Spiele
* Spiele als Hauptschiedsrichter
* Spiele als Schiedsrichterassistent
* Siege
* Unentschieden
* Niederlagen
* Tore per Elfmeter
* Tore per Elfmeter für den Verein
* Tore per Elfmeter gegen den Verein
* Elfmeter
* Elfmeter für den Verein
* Elfmeter gegen den Verein
* Gelbe Karten
* Gelbe Karten für den Verein
* Gelbe Karten gegen den Verein
* Gelbe-rote Karten
* Gelbe-rote Karten für den Verein
* Gelbe-rote Karten gegen den Verein
* Rote Karten
* Rote Karten für den Verein
* Rote Karten gegen den Verein

