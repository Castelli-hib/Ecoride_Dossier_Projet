# Workflow Git pour Ecoride / Symfony Global Information Tracker

Git est un framework, c'est une application, il est effectif si on travaille à plusieurs

Fonctionnement
Par Branche
On tire ddes solutions temporaires sur des branches

GitHub est une entreprise + ajout d'autres briques et de finition
git Actions = application qui recupere le code est fait du pipeline
ci/Cd = des événement et des actions sur notre code
Continuos Intégration (integration du code en continue) execute

1-Créer le repository + new = a nommer suivant le nom du projet
REenseigne les éléments de communication
Pour communiquer avec Git
le code doit être chiffrer
https = secure facon de communiquer entre les deux avec le s c'est sécure pas sillple
ssh = c'est le sécure shell, permet de créer un canal toujours securisé. Qui va générer un private key et un public key (la private key pour chiffrer et la public key pour déchiffrer les données envoyé vont etre chiffrer avec le private key et on mes envoi)

une fois le repository créer on récupere le ssh pour faire la liaison avec notre projer et injecter notre code, c'est le lien du répertoire Gityes

Git init = il va créer un fichier dans mon répertoire et a tracker tout ce qu'il voit, d'ou l'affiche sur bnotre IDE du nombre de modification executée. Fichier indéxé

ls= lister
ls -la // cd
.git = c'est le distibuteur hébergé en local

git remote -v = donne l'adresse du repo distant avec qui on veut communiquer, il doit dire vous étes ... le chemin
Pour ajouter le lien distant
git add .

## 1. Branches principales

- **main**  
  Contient le code stable et déployable.  
  On ne touche à `main` que pour des versions testées et validées.
  git branch -M main : pour changer master en main

- **devop (ou develop)**  
  Branche de développement.  
  Tous les changements passent par `devop` avant d’être fusionnés dans `main`.  
  Sert de base pour créer des branches fonctionnalités ou correctifs.

---

## 2. Branches secondaires (features / bugfix)

- ** Nommer les branches par type et fonctionnalité, par exemple :  

feature/registration-form
feature/search-trajet
bugfix/fix-login

## Elles partent toujours de `devop`  

git checkout devop
git checkout -b feature/registration-form

<!-- Une fois terminées, elles sont fusionnées dans devop : -->
git checkout devop
git merge feature/registration-form
git push origin devop

## 3. Fusion dans main

- ** Quand devop est stable (après tests locaux ou unitaires) :
git checkout main
git merge devop
git push origin main
git push origin devop

## Fusionner devop dans main quand stable

git checkout main
git pull origin main
git merge devop
git push origin main
Conseil : toujours ignorer les fichiers sensibles et volumineux (.env, vendor/, node_modules/, var/, public/build/) pour garder le dépôt propre.

## Ajouter les fichiers à l’index (staging area)

git add README.md
git add .

## Committer les changements avec un message clair

git commit -m "Ajout du README avec les commandes Docker essentielles"

## Pousser la branche sur le dépôt distant (feature/readme)

git push -u origin feature/readme

## (Optionnel) Créer une Pull Request sur GitHub pour fusionner feature/readme dans devop une fois que tout est prêt et relu

pull request ? (a voir)

## Ajouter le dossier à l’index Git

git add Documents_README/

## Committer les changements

git commit -m "Ajout du dossier Documents_README avec tous les README"

## Créer une branche

git checkout -b feature/ma-feature

## Commit (s'engager)

git add .git status
git commit -m "Message clair"

## Premier push

git push -u origin feature/ma-feature

## Push suivant

git push

## Mise à jour avec develop

git checkout develop && git pull origin develop
git checkout feature/ma-feature
git merge develop

## Astuces

astuce : exécutez « git fetch » pour le récupérer.
astuce : si vous prévoyez de pousser une nouvelle branche locale qui suivra son équivalent distant, vous pouvez utiliser
« git push -u » pour définir la configuration en amont lors de la poussée.

astuce : désactivez ce message avec « git config set advice.setUpstreamFailure false »

git log

ci/cd cd d=deploiment (paramatrage du piplemine)
circleci.com (gitLab) liste d'instruction, liste les étapes

## git cherry-pick + id 'du commit'

## git cherry-pick + id +i

récupere le commit

## 📌 Résumé rapide (copie facile)

git checkout feature/deployment
git add README.md
git commit -m "Update README"
git checkout dev
git pull origin dev
git merge feature/deployment
git push origin dev
