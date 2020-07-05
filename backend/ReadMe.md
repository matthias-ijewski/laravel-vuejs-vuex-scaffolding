# Euregio im Bild

## Aufgabenstellung
Es soll eine API erstellt werden, die eine geeignete Authentifizierung für eine klassische Webapplikation, eine vue.js Webapplikation und mobile Apps gleichermaßen bereitstellt.

## Aufgabenlösung
Die Erweiterung Passport wurde installiert und konfiguriert. Dazu wurde entsprechende Middleware erstellt und eingerichtet. Meldet sich ein Benutzer in der Webapplikation an, erhält er durch die CreateFreshApiToken-Middleware ein API-Token, das für die Kommunikation von vue.js mit der API verwendet wird. Durch das Passport-UI-Scaffolding können über die Webapplikation außerdem Client-Secrets für die Kommunikation mit Apps erstellt werden. Die Authentifizierung der App-Benutzer erfolgt mit oAuth2.

## Besonderheiten
Die Middleware CheckPassportClientCredentials extrahiert bei App-Requests aus dem oAuth2-Token die Client-ID, die fortan als client_id im Request verfügbar ist.

## Erweiterte Features
 - Datenbankgetriebene Job-Queues
 - Benutzer müssen ihre E-Mail-Adresse verifizieren

### Installation
composer install\
php artisan migrate\
php artisan passport:install\
php artisan passport:keys\
npm install\
npm run dev

### Konfiguration
In der .env muss QUEUE_CONNECTION=database gesetzt werden

## Features
 - vuex
 - passport oauth token
 - signin form submit on enter
 - full screen signin and submit forms
 - protected private image routes
 - image caching
 - the php league glide
 - img auth with inline img and passport
 - cache clearing functionality
