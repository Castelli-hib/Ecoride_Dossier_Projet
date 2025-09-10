# Docker – Commandes essentielles

## Vérification & infos

- `docker --version` → Vérifie la version installée  
- `docker info` → Infos sur l’installation Docker  
- `docker ps` → Liste les conteneurs en cours d’exécution  
- `docker ps -a` → Liste tous les conteneurs (même arrêtés)  
- `docker images` → Liste les images locales  
- `docker volume ls` → Liste les volumes  
- `docker network ls` → Liste les réseaux  

## Images

- `docker pull <image>` → Télécharger une image depuis Docker Hub  
- `docker build -t monapp .` → Construire une image depuis un Dockerfile  
- `docker rmi <image_id>` → Supprimer une image  

## Conteneurs

- `docker run hello-world` → Lancer un test simple  
- `docker run -it ubuntu bash` → Lancer un conteneur interactif  
- `docker run -d -p 8080:80 nginx` → Lancer un conteneur en arrière-plan  
- `docker start <container_id>` → Démarrer un conteneur arrêté  
- `docker stop <container_id>` → Arrêter un conteneur  
- `docker restart <container_id>` → Redémarrer un conteneur  
- `docker rm <container_id>` → Supprimer un conteneur  
- `docker logs -f <container_id>` → Voir les logs en temps réel  
- `docker exec -it <container_id> bash` → Ouvrir un terminal dans un conteneur  

## Volumes & fichiers

- `docker volume create mon_volume` → Créer un volume  
- `docker volume rm mon_volume` → Supprimer un volume  
- `docker cp <container_id>:/chemin/fichier ./` → Copier un fichier du conteneur vers l’hôte  

## Réseaux

- `docker network create mon_reseau` → Créer un réseau  
- `docker network connect mon_reseau mon_container` → Connecter un conteneur à un réseau  
- `docker network inspect mon_reseau` → Inspecter un réseau  

## Nettoyage

- `docker system prune -f` → Supprimer conteneurs/volumes/images inutilisés  
- `docker image prune -a` → Supprimer toutes les images inutilisées  
- `docker container prune` → Supprimer conteneurs arrêtés  
- `docker volume prune` → Supprimer volumes non utilisés  

## Docker Compose

- `docker-compose up -d` → Démarrer les services en arrière-plan  
- `docker-compose ps` → Voir les services lancés  
- `docker-compose logs -f` → Voir les logs  
- `docker-compose down` → Arrêter et supprimer les conteneurs  

## Vider le cache

## !/bin/bash

## Script pour vider et réchauffer le cache Symfony dans Docker

- `docker exec -it php bash -c "rm -rf var/cache/*"`

- `docker exec -it php php bin/console cache:warmup`

 echo "Cache vidé et reconstruit avec succès !"
