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
