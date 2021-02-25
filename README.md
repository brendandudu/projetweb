# RESA

Bonjour et bienvenue sur notre projet RESA !

RESA c'est quoi ? un site de réservation d'hebergements : Chalet, bungalow, mobil-home dans toute la france.

# BUNDLES

Charger les composants avec composer : $ composer install

# BDD

Créer la base de donnée : $ php bin/console doctrine:database:create

Charger la base de donnée : $ php bin/console doctrine:migrations:migrate

# FIXTURES

Pour charger les fixtures : $ php bin/console doctrine:fixtures:load

# BACK-OFFICE :

URL : 127.0.0.1:8000/admin

Email admin : admin@gmail.com
Password : Admin2021@

# Tests

Créer la base de donnée pour les tests : $ php bin/console doctrine:database:create --env=test

Puis créer la structure des tables :  php bin/console doctrine:schema:update --env=test --force

Avant de lancer les tests pensez à charger les fxtures pour la base de test : $ php bin/console doctrine:fixtures:load --env=dev

Lancer les tests : $ php bin/phpunit

