# git remote -v

origin  `git@github.com:castelli-hib/Ecoride_1erDepot.git` (push)

ghcr.io/Castelli-hib/ecoride:latest

bash
docker tag ecoride ghcr.io/castelli-hib/ecoride:prod

Se connecter
docker login ghcr.io -u castelli-hib

Pousser l’image vers GHCR
docker push ghcr.io/castelli-hib/ecoride:prod

Sur le VPS
ssh user@IP_VPS

docker login ghcr.io
docker pull ghcr.io/castelli-hib/ecoride:prod
docker run -d -p 80:80 ghcr.io/castelli-hib/ecoride:prod

## 📌 POUR RÉSUMER CE QUE TU AS FAIT VS CE QU'IL MANQUE

Étape                         Tu as fait             VPS OK ?
Build image locale            ✔️                     ❌ NON
Tag image locale simple       ✔️                     ❌ NON
docker compose local          ✔️                     ❌ NON
Tag pour GHCR                 ❌                     ❌ NON
Push vers GHCR                ❌                     ❌ NON
Pull sur VPS                  ❌                     ❌ NON
Déploiement réel              ❌                     ❌ NON

Donc :
Ton image existe bien, mais seulement sur ta machine.
Le VPS ne la verra jamais tant que tu ne la pushes pas sur GHCR.

Bon ça c'est pas passé comme prévu
