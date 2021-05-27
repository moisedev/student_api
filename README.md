Installation back-end (Symfony pour un microservice, console application API version 5.2 ):
1- Ajout fichier environnement ( .env ):
Model : student_api\ .env.local dupliquer le model et renommer le par .env
Modification configuration selon votre serveur avec DATABASE_URL

Dans le repértoire students_api :
exécuter les commandes suivantes
2 -composer install --prefer-dist
3- php bin/console doctrine:database:create
4- php bin/console doctrine:migrations:migrate