# TNormform
Die TNormform stellt das Grundgerüst für Übungen im Web-Entwicklungsbereich zur Verfügung.

Templates und CSS werden vollständig zur Verfügung gestellt, weil dies in anderen Vorlesungs- und Übungsblöcken
vermittelt wird. Dadurch soll es möglich sein, sich auf den eigentlichen Lerninhalt, das Erlernen von PHP,
zu konzentrieren.

Besuchen sie uns unter https://www.fh-ooe.at/en/hagenberg-campus/studiengaenge/bachelor/media-technology-and-design/

Verwendete Technologien und Vorraussetzungen

Für das Übungsscenario wurde mit [XAMPP](https://www.apachefriends.org/de/index.html)  entwickelt. TNormform lässt sich aber auch unter anderen Umgebungen
installieren.

* [HTML5](https://www.w3.org/TR/html5/)
* [CSS3](https://www.w3.org/Style/CSS/specs)
* [objectorientiertes PHP](http://php.net/)
* [Smarty Templates](http://www.smarty.net/)
* [jsOnlyLightbox](https://github.com/felixhagspiel/jsOnlyLightbox)
* [CSS3 Flexbox](https://www.w3.org/TR/css-flexbox-1/)
* [jquery](https://jquery.com/), als Teil der Übung, aber nicht als Teil des Grundgerüstes 

In der Methode TNormform::normForm() wird ein einfaches Pattern vorgegeben, das den Aufruf, die Eingabe von Daten und deren Verarbeitung über ein Webformular steuert.
Über die Klasse Utilities werden Hilfsfunktionen zur Eingabeüberprüfung und zur Seitenweiterleitung zur Verfügung gestellt.
Die Klasse DemoTNormForm dient zur Demonstration der Abläufe. 
In den Webübungen und [Datenbankübungen](https://github.com/Digital-Media/MH_DBA-DAB_OnlineShop) wird auf diesem Repository aufbauend die Verarbeitung der Daten (Speichern im Filesystem oder Datenbank, ...) ergänzt.


