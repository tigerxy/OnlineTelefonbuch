# OnlineTelefonbuch
Online-Telefonbuch für Gigaset C610 IP und C610A IP.

Seit Klicktel im März 2018 ihre OpenAPI abgeschaltet hat, werden bei einem Gigaset die Anrufernamen nicht mehr angezeigt. Ich fand diese Funktion sehr hilfreich und hat für mich einen echten Mehrwert eines IP Telefons geliefert. Leider gibt es von Gigaset offiziell für Deutschland keinen mitgelieferten Provider, also habe ich mir ein kleines PHP Skript zum Behelf gestrickt.

Bei Fragen darf gerne ein Issue geschrieben werden.

# Intallation
Sie benötigen einen PHP Server. Auf diesem laden Sie das Skript `oertliche.php` hoch. Die URL zu diesem Skript werden sie später als `Serveradresse` benötigen.

# Einrichtung
Ich habe diese Anleitung für die Firmware-Version 42.247 geschrieben.

Zu Beginn in der Weboberfläche der Telefonbasis anmelden. Zu der Seite `Einstellungen -> Telefonbücher -> Online-Telefonbuch` navigieren.

Auf dieser Seite bei `Einstellungen für einen zusätzlichen Provider` auf `Bearbeiten` klicken.

![Schritt 1](Schritt1.jpg)

Nun `Anbietername` und `Serveradresse` ausfüllen und mit `Sichern` bestätigen

![Schritt 2](Schritt2.jpg)

Nun `Häkchen` neben dem zuvor festgelegten Anbieternamen setzen und diesen bei `Automatische Suche des Anrufernamens` auswählen.

![Schritt 3](Schritt3.jpg)

Fertig. Wenn alles geklappt hat, erscheint beim nächsten bekannten Anrufer, der Name, wie von früher gewohnt, im Display.

# Weitere Informationen
Ich habe diese [Dokumentation](https://teamwork.gigaset.com/gigawiki/display/GPPPO/Online+directory) von Gigaset gefunden, die mir bei der Implementierung geholfen hat.

[![](https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=MCKETSJBUZPJ2&source=url)
