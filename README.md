

Comandos para correr el proyecto:

+ Crea el archivo .env en base a el archivo .env.example

+ Genera una nueva Key con:
  php artisan key:generate

+ Instala composer:
  composer update o composer install

+ Corre las migracones y los seeders:
  php artisan migrate --seed

Pruebas del sistema:

* Metodo Get_Token: 

POST http://127.0.0.1:8000/api/Get_Token

{
    "user": "Alandev",
    "password": "Prueba@tecnica1"
}


* Metodo Create_User:

POST http://127.0.0.1:8000/api/Create_User

Inserta:

{
    "name": "name",
    "phone": "72221992288",
    "user": "Alandev2025",
    "password": "Prueba@tecnica1",
    "Consent_ID1": true,
    "Consent_ID2": true,
    "Consent_ID3": true
}


* Metodo Update_User:

UPDATE http://127.0.0.1:8000/api/Update_User/2

{
    "name": "Cesar",
    "phone": "555555555",
    "user": "Cesardev",
    "password": "Prueba@tecnica2",
    "Consent_ID2": false,
    "Consent_ID3": false
}

* Metodo Delete_User:

DELETE http://127.0.0.1:8000/api/Delete_User/1



