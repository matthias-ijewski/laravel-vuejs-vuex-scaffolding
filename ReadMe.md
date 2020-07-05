# Laravel Backend & Vue.js mit Vuex Frontend Scaffolding

## Aufgabenstellung
Es soll eine API erstellt werden, die eine geeignete Authentifizierung für eine klassische Webapplikation, eine Vue.js Webapplikation und mobile Apps gleichermaßen bereitstellt.

## Aufgabenlösung
Die Erweiterung Passport wird installiert und konfiguriert. Dazu wird entsprechende Middleware erstellt und eingerichtet. Meldet sich ein Benutzer in der Webapplikation an, erhält er durch die CreateFreshApiToken-Middleware ein API-Token, das für die Kommunikation von Vue.js mit der API verwendet wird. Durch das Passport-UI-Scaffolding können über die Webapplikation außerdem Client-Secrets für die Kommunikation mit Apps erstellt werden. Die Authentifizierung der Benutzer erfolgt mit oAuth2.

## Besonderheiten
Die Middleware CheckPassportClientCredentials extrahiert bei App-Requests aus dem oAuth2-Token die Client-ID, die fortan als client_id im Request verfügbar ist.\
Die erweiterte BearerTokenResponse reichert alle Antworten auf Token-Requests (login, register & refresh) mit dem angemeldeten User an.


## Features
 - vuex modules
 - auth with passport
 - vuejs signin form submit on enter
 - vuejs routing with dialogs
 - vuejs full screen signin and signup forms unsing dialogs
 - protected private image routes
 - the php league glide
 - image caching of automatically resized images server side
 - image cache clearing functionality
 - database driven job queues
 - server & frontend side validation
 - multilanguage support with laravel-translatable

## Installation

### Backend

Datenbank erstellen\
.env konfigurieren\
npm install\
composer install\
QUEUE_CONNECTION=database in der Backend .env setzen
php artisan migrate\
php artisan serve\
Benutzer anlegen\
Mit Benutzer einloggen\
Passport OAuth-Client erzeugen\
Der OAuth-Client muss in der Datenbank-Tabelle oauth_clients als Passwort-Client registriert sein (password_client = 1)\
(php artisan passport:install)\
php artisan passport:keys\
npm run dev\

Damit Änderungen in der Frontend .env wirksam werden, muss "npm run serve" beendet und neu gestartet werden\

### Frontend

Passport OAuth-Client-Secret in Frontend .env eintragen\
Passport OAuth-Client-ID in Frontend .env eintragen\
npm install\
npm run serve

