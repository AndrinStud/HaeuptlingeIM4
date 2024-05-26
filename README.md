# Dokumentation
**Myriam Häubi, Dea Caviziel, Andrin Schärli**
Zu Beginn des Projektes haben wir uns für die API von Shared Mobility entschieden. Dort werden die Scooter, Mobility Cars und Fahrräder angezeigt. Dabei werden verschiedene Anbieter angezapft. Die Fahrzeuge werden mit Koordinaten und Verfügbarkeit angezeigt. Dies wollten wir nutzen, um darzustellen, wie sich die Fahrzeuge innerhalb einer gewählten Zone (Winterthur) bewegen. Dadurch soll ein Besucher der Website sehen, zu welchen Zeiten die Fahrzeuge vermehrt wo sind und sich vielleicht ein Schema bildet. Auch soll erkannt wie die Nutzung der Trottis über den Tag hinweg aussieht und wie ausgelastet die Stationen sind.

## Learnings:
Wir lernten (wieder einmal) wie wichtig die Kommunikation untereinander ist. Und dass erst ein Plan stehen sollte, bevor man losarbeitet. 
Das GPT launisch ist. Plugins sind sehr nützlich.

## Schwierigkeiten:
Schon zu Beginn hatten wir Schwierigkeiten damit, herauszufinden wie wir ein einzelnes Fahrzeug ansprechen können. Dafür verwendeten wir mehrere Stunden, um doch nicht wirklich ein Resultat zu erhalten. 
Dann gab es Schwierigkeiten für einzelne Gruppenmitglieder, da das Verständnis für IM bei allen anders war. 
Wir starteten ziemlich direkt mit dem Coden und vergassen erst mal den Aspekt der Geschichte, die wir erzählen wollen mit unseren Daten. Durch eher wenig Kommunikation schauten wir erst in der zweiten IM-Woche an, wie unser Design aussehen sollte.
Das Verbinden mit DB stellte sich als grosse Herausforderung heraus. 
Einen interaktiven Kalender und Slider zu coden, war für die nicht so erfahrenen Coder doch eher schwierig. Zudem wurde das Umrechnen der Koordinaten von der Map von Admin Geo zu Leaflet Openstreetmap eine lange Prozedur die viele Nerven kostete.
Unsere API gibt keine Daten aus, dort meldeten wir uns und die Leiteten das Problem weiter. Aber bis unser Projekt abgegeben werden muss, wissen wir nicht ob wir überhaupt daten erhalten. Daher mussten wir Daten erfinden.
API Abruf: 652 abrufen, kann aber nur 50 auf einmal abrufen. Zuletzt hatten wir alle abgerufen, diese waren aber nicht aktuell, da die API seit dem 29.04.2024 keine Daten mehr lieferte. Wir sind nicht enttäuscht, wir sind Hässig.

## Ressourcen:
Bei vielem half unser Gruppenmitglied Andrin, da er sich am besten mit dem Programieren auskennt. Ansonsten fragten wir ChatGPT, benutzten Plugins und Copilot und wenn das nicht klappte gingen wir zu einem Dozenten.
Bei Fragen bezüglich des Designs in Figma benutzten wir auch gerne YouTube.


# Anleitung zum Start
## Schritt 1: Variablen für Visual Studio SFTP-Extension einrichten
1. Auf oberster Ebene Ordner **.vscode** erstellen
2. Darin eine Datei mit dem Namen **sftp.json** erstellen
3. Folgendes muss dort rein:

    	{
	        "name": "IM4_HaeuptlingeProj_DEV",
	        "host": "HOST",
	        "protocol": "ftp",
	        "port": 21,
	        "username": "USERNAME",
	        "password": "PASSWORD",
	        "remotePath": "/web/",
	        "uploadOnSave": true,
	        "ignore": [
	            ".vscode",
	            ".git",
	            ".DS_Store",
	            "README.md",
	            ".gitignore"
	        ]
        }
    > **Wichtig:** *HOST*, *USERNAME* und *PASSWORD* müssen nun durch die FTP-Anmeldedaten des Entwicklungsserver ersetzt werden!

## Schritt 2: Umgebungsvariablen einrichten
1. Auf oberster Ebene Datei **.env** erstellen
2. Folgendes muss dort rein:

    	DB_NAME=DATENBANKNAME
    	DB_USER=BENUTZERNAME
    	DB_PASS=PASSWORT

    > **Wichtig:** *DATENBANKNAME*, *BENUTZERNAME* und *PASSWORT* müssen nun durch die Anmeldedaten der Datenbank deines Entwicklungsserver ersetzt werden!
