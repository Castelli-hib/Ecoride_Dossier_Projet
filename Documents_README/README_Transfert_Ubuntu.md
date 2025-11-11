# Setup Ubuntu Docker — Projet Ecoride

## Objectif

Migrer mon projet Symfony **Ecoride** depuis Windows vers **Ubuntu (WSL)**,  
en gardant un environnement Docker propre et fonctionnel  
(php, mysql, mailhog, phpmyadmin).

---

## 1️-Préparation du dossier

```bash

cd ~    //~ est un raccourci vers ton dossier personnel (aussi appelé home directory). 
'~  ≡  /home/adiktionstudio' cd /home/adiktionstudio


mkdir -p ~/Projets  Crée un dossier Projets dans ton home,
donc : /home/adiktionstudio/Projets
cd ~/Projets    déplace à l’intérieur de ce dossier.

2
Clonage du projet depuis GitHub
Assure-toi d’être bien connecté à ton compte GitHub (SSH ou HTTPS).

Si tu utilises SSH :
bash

git clone -b feature/ubuntu git@github.com:Castelli-hib/Ecoride_1erDepot.git

Si tu préfères HTTPS :

bash
git clone -b feature/ubuntu https://github.com/Castelli-hib/Ecoride_1erDepot.git
Puis entre dans ton dossier :

bash
cd Ecoride_1erDepot

Vérifier la branche et le dépôt

bash
git status
git branch
Résultat attendu :

vbnet

On branch feature/ubuntu
Your branch is up to date with 'origin/feature/ubuntu'.

Vérifier Docker dans WSL
Teste la connexion Docker :

bash
docker version
Si tu vois une erreur du type permission denied :

bash
sudo usermod -aG docker $USER
newgrp docker

Puis vérifie à nouveau :

bash
docker ps


Démarrer l’environnement
Ton fichier compose.yaml remplace désormais l’ancien docker-compose.yaml.

Lance simplement :

bash
docker compose up -d

Cela va :
Construire les images si nécessaire,
Lancer tes services PHP, MySQL, Mailhog, PhpMyAdmin.
Vérification des conteneurs

bash
docker ps -a --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
Résultat attendu :

nginx

phpmyadmin            Up (healthy)   0.0.0.0:8899->80/tcp
ecoride-mailhog-1     Up (healthy)   0.0.0.0:8025->8025/tcp
database              Up (healthy)   0.0.0.0:4306->3306/tcp
php                   Up (healthy)   0.0.0.0:8080->80/tcp

Accès aux services
Service URL d’accès local
Site Symfony    http://localhost:8080
PhpMyAdmin      http://localhost:8899
Mailhog         http://localhost:8025

8️Arrêter / Nettoyer les conteneurs
bash

docker compose down
Supprimer les volumes (base de données, cache, etc.) :

bash

docker compose down -v


9️Commandes utiles
Action  Commande
Recompiler le code Symfony  symfony console cache:clear
Lancer les migrations   symfony console doctrine:migrations:migrate
Voir les logs   docker compose logs -f
Se connecter au conteneur PHP   docker exec -it php bash

Bonnes pratiques
Ne pas versionner mysql_data/ → ton .gitignore le protège déjà.

Toujours travailler dans une branche dédiée (ex: feature/ubuntu).

Vérifie régulièrement ton fichier compose.yaml (il est désormais la référence).

Utilise symfony serve uniquement en local sans Docker.

Migration réussie
Ton projet est maintenant fonctionnel dans Ubuntu (WSL), 
avec un environnement Docker stable et prêt à l’emploi
