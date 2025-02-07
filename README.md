

Comandos para correr el proyecto:

+ Crea el archivo .env en base a el archivo .env.example

+ Genera una nueva Key con:
  php artisan key:generate

+ Instala composer:
  composer update o composer install

+ Corre la migracones:
  php artisan migrate

Pruebas del sistema:

* Metodo Create_User:
POST http://127.0.0.1:8000/api/Create_User

Inserta:

{
    "name": "name",
    "phone": "72221992288",
    "user": "Alandev",
    "password": "Prueba@tecnica1",
    "Consent_ID1": true,
    "Consent_ID2": true,
    "Consent_ID3": true
}