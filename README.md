# RESA

Bonjour et bienvenue sur notre projet RESA !

RESA.fr c'est quoi ? un site de réservation d'hébergements de particulier à particulier, tout comme AirBnb, mais en mieux ! Venez profiter d'un large choix de location disponible partout en France : Châlet, bungalow, mobil-home.. Découvrez de nouvelles opportunités ;-)

Fonctionnalités principales : - Se connecter / S'inscrire
                              - Chercher un hébergement par lieu, date de disponibilité et nombre d'invité
                              - Consulter un hébergement
                              - Réserver un hébergement
                              - Enregistrer un hébergement dans sa wishlist
                              - Accéder à toutes sortes d'information concernant son profil (infos personnelles, réservations effectuées, liste d'envie..).
                              - Back office pour administrer le site

# Comptes

Admin
Email: admin@gmail.com
Password : Resa2021@

Invité
Email: user@gmail.com
Password : Resa2021@

Hôte
Email: host@gmail.com
Password : Resa2021@

# Export BDD

Url :


# Outil de gestion de projet 

Url : 


# Conseils d'utilisations

Pour rechercher un hébergement : essayez de chercher à Brest, Paris, Marseille ou bien encore Bordeaux.

Le changement d'image de profil génère pour l'instant une erreur mais sinon fonctionne quand même.


# FIXTURES

Le site dispose d'un jeu de données.

Pour charger les fixtures : $ php bin/console doctrine:fixtures:load


# BACK-OFFICE :

(Disponible que pour les comptes admin)
URL : 127.0.0.1:8000/admin


# Tests

Créer la base de donnée pour les tests : $ php bin/console doctrine:database:create --env=test

Puis créer la structure des tables :  php bin/console doctrine:schema:update --env=test --force

Avant de lancer les tests pensez à charger les fxtures pour la base de test : $ php bin/console doctrine:fixtures:load --env=dev

Lancer les tests : $ php bin/phpunit

