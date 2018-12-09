criptions

Ce dépot contient le projet Symfony Simpleo,on appliquera nos modifications sur le projet ici.

Vous devez suivre les instructions sur le depot vagrant avant de continuer.

https://dwarves.iut-fbleau.fr/git/renaults/Vagrant


## Commandes

Parfait vous avez bien cloner le dépot, suivez maintenant les instructions.

1 - cd Simpleo

*Maintenant on va lancer nos contenaires msql,apache et notre web*

2 - docker-compose up -d 

*On s'assure que nos contenaires ont bien été lanceés *

3 - docker ps

*Pour entrer dans un contenaire
ex : php-apache
*

4 - docker exec -it `nom du contenaire` bash 

*Maintenant vous etes entré dans le contenaire, dans le contenaire php-apache c'est ici on fera des commandes 
*

5 - exit ( sortir d'un contenaire)


## Informations

Ajouter la ligne : 192.168.33.10 simpleo.local
de votre fichier host de votre machine local.
## Accès

*Pour accéder au site Simpleo* 
http://simpleo.local/

*Pour accéder a Phpmyadmin*
http://simpleo.local:8080/
