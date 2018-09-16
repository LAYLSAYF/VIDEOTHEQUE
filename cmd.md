Gestion des films - Commandes Syfomy 3 
========================

Symfony :
SF 3

#ORM :
Doctrine 2

#SGBD : 
MYSQL

# Purge BDD :
php app/console doctrine:database:drop  --force
php app/console doctrine:database:create
php app/console doctrine:schema:create

# ALimentation de la BDD par des données factices
php app/console doctrine:fixtures:load


#Installation des Bundles: 
1) KnpPaginatorBundle
2) DoctrineFixturesBundle (en mode dev)

#technologie front
Framwork Bootstrap V3

# Utilisation d'un custom Service ( injection de dépendances ) 
FlashMessagesService