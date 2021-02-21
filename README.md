# RESA

Bonjour et bienvenue sur notre projet RESA !

RESA c'est quoi ? un site de réservation d'hebergements : Chalet, bungalow, mobil-home dans toute la france.

# BUNDLES

Charger les composants avec composer : $ composer install

# BDD

$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate

# FIXTURES

Pour charger les fixtures : $ php bin/console doctrine:fixtures:load

# BACK-OFFICE :

URL : 127.0.0.1:8000/admin

Email admin : admin@gmail.com
Password : Admin2021@

# Tests

Base de donnée pour les Tests : $ php bin/console doctrine:database:create

Lancer les tests : $ php bin/phpunit

