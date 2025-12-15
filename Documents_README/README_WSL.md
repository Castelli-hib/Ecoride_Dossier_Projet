# FICHE MÉMO — SSH & WSL : Clés, commandes et VPS

> Guide rapide pour comprendre, manipuler et sécuriser ses clés SSH, se connecter à un VPS,
> gérer ses paquets Debian, et pousser des images Docker vers GitHub Container Registry (GHCR).

---

## 1. Clés SSH — métaphore

| Élément        | Métaphore            | Fichier                  | À partager ? |
|----------------|----------------------|---------------------------|---------------|
| 🔒 Clé privée   | **La serrure**       | `~/.ssh/id_ed25519`       | ❌ Jamais     |
| 🔑 Clé publique | **La clé**           | `~/.ssh/id_ed25519.pub`   | ✅ Oui        |
| 🧾 known_hosts  | Liste des serveurs approuvés | `~/.ssh/known_hosts` | —             |

- **Clé privée** : reste sur ma machine, prouve mon identité.
- **Clé publique** : à copier sur GitHub, GitLab ou sur mon VPS pour autoriser l’accès.

---

## 2. Navigation dans le dossier `.ssh`

```bash
cd                # Aller dans ton répertoire personnel
cd ~/.ssh         # Aller dans le dossier des clés SSH
ls -l             # Lister les fichiers et permissions


---

3. Renommer ou déplacer des clés

Renommer la clé privée :

mv id_ed25519 id_ed25519_github


Renommer la clé publique :

mv id_ed25519.pub id_ed25519_github.pub


⚠️ Si je renomme les fichiers, je dois les spécifier manuellement :

ssh -i ~/.ssh/id_ed25519_github user@host

4. Générer une nouvelle paire de clés SSH (ed25519)
ssh-keygen


En appuyant sur Entrée, j’accepte le chemin par défaut :

Enter file in which to save the key (/home/user/.ssh/id_ed25519):


Laisser vide pour la passphrase (sinon, un mot de passe sera demandé à chaque connexion).

Résultat attendu :

Your identification has been saved in ~/.ssh/id_ed25519
Your public key has been saved in ~/.ssh/id_ed25519.pub

5. Afficher et copier ta clé publique
cat ~/.ssh/id_ed25519.pub


Copier la ligne entière (commence par ssh-ed25519 AAAA...).

À coller :

Sur GitHub → Settings → SSH and GPG keys → New SSH key

Sur VPS → dans le fichier ~/.ssh/authorized_keys

6. Connexion SSH à mon VPS
ssh debian@ecoride.adiktionstudio.com


Première connexion → le système affiche l’empreinte du serveur → répondre yes.

Si Debian demande un changement de mot de passe :

You are required to change your password immediately


Puis se reconnecter normalement :

ssh debian@ecoride.adiktionstudio.com

7. Commandes système utiles sous Debian

Mettre à jour le système :

sudo apt update
sudo apt upgrade


Installer un paquet :

sudo apt install nginx

À comprendre :

sudo = “super user do” → exécute en tant qu’administrateur.

apt = gestionnaire de paquets Debian.

8. Commandes Docker essentielles

Lister les images :

docker images


Lancer un conteneur :

docker run -d -p 6969:80 jesussortdececorps


-d : mode détaché (en arrière-plan)

-p 6969:80 : mappe le port 80 du conteneur vers le port 6969 local

Voir les conteneurs actifs :

docker ps


Entrer dans un conteneur :

docker exec -it hardcore_almeida sh

Créer un fichier test à l’intérieur :

echo "Push push, la Patateee" > index.html

9. GitHub Container Registry (GHCR)
Étape 1 — Créer un token personnel

Sur GitHub :
Settings → Developer settings → Personal access tokens → Fine-grained token
→ Cocher les permissions liées aux packages.

Étape 2 — Définir le token comme variable
export CR_PAT=ghp_votreTokenGitHub
echo $CR_PAT

Étape 3 — Connexion à GHCR
echo $CR_PAT | docker login ghcr.io -u VotreNomGitHub --password-stdin


Résultat attendu :

Login Succeeded

Pousser une image Docker :

docker push ghcr.io/votrenom/image:latest

10. Bonnes pratiques de sécurité
Bon réflexe	Description
Permissions sécurisées - chmod 600 ~/.ssh/id_ed25519
Passphrase facultative	Augmente la sécurité si mon PC est partagé
Jamais de clé privée publique - Ne jamais coller id_ed25519 sur internet
Sauvegarde chiffrée	Copier les clés dans un coffre-fort numérique
Identités distinctes une clé SSH différente par service (GitHub, VPS, etc.)


11. Quitter le WSL proprement

Deux méthodes :

logout
# ou
Ctrl + D

Résumé rapide
Action	Commande clé	Objectif
Générer une clé SSH	ssh-keygen	Créer clé privée/publique
Voir la clé publique	cat ~/.ssh/id_ed25519.pub	Copier pour GitHub/VPS
Connexion au VPS	ssh debian@ecoride.adiktionstudio.com	Accès distant
Mise à jour Debian	sudo apt update && sudo apt upgrade	Système à jour
Lancer un conteneur	docker run -d -p 6969:80 image	Déploiement web
Connexion GHCR	`echo $CR_PAT	docker login ghcr.io -u user --password-stdin`



---
