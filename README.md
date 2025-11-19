# Ecoride — Documentation Technique

Bienvenue dans la documentation officielle du projet **Ecoride**, une plateforme de covoiturage écologique basée sur Symfony, Docker et une architecture modulaire.

## Objectifs fonctionnels

- Mettre en relation passagers et conducteurs  
- Création et recherche de trajets  
- Espace utilisateur (profil, trajets, réservations)  
- Espace employé (modération, litiges)  
- Espace administrateur  
- Communication interne entre usagers  

## Technologies principales

- Symfony (backend)
- Bootstrap / SCSS (frontend)
- Docker & WSL2 (environnement)
- MySQL (BDD)

## Environnement de développement

## Système

- Windows 11 + WSL2 (Ubuntu ou Debian)
- Docker Desktop
- PHP 8.x / Composer
- Symfony CLI
- Node / npm / NVM
- VSCode

## Installation WSL2

wsl --install
sudo apt update && sudo apt upgrade -y
Installation Docker
Docker Desktop avec backend WSL2

docker --version
docker compose version
Installation Node via NVM

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
nvm install 20
nvm use 20
Installation du projet Symfony

symfony new app --webapp
composer install

---

## Architecture logicielle et Docker

## Conteneurs utilisés

| Service       | Rôle |
|---------------|------|
| app           | PHP / Symfony |
| mysql         | Base de données |
| phpmyadmin    | Interface SQL |
| mailhog       | Test SMTP |

## Arborescence projet

ecoride/
  app/
    dockerfile.dev
    apache/default.conf
  compose.yaml
  mysql/

---
## Front-end

## Technologies

- Bootstrap 5
- SCSS personnalisé
- Mobile-first → Desktop

## Composants prévus

- Header / Navbar
- Section Hero
- Cartes (trajets, conducteurs)
- Formulaires (inscription, recherche, réservation)
- Thème responsive conforme à la charte graphique

## Structure SCSS

assets/
styles/
base/
components/
layout/
pages/

## Structure

src/
Controller/
Entity/
Repository/
Form/
Security/
Service/

## Entités existantes

- User
- Route
- Reservation
- Vehicle
- Preferences
- Brand
- Contact
- Avis

### À ajouter

- Credit
- Litige

## Migrations

symfony console make:migration
symfony console doctrine:migrations:migrate
Fixtures

composer require --dev orm-fixtures fakerphp/faker
symfony console doctrine:fixtures:load
Exemple Repository (QueryBuilder)

## Objectifs
- Recherche de trajets
- Réservations
- Profil utilisateur
- Gestion des véhicules
- Avis & litiges
- Messagerie interne

---

# Sécurité & Authentification

## JWT avec LexikJWTAuthenticationBundle

### Fonctionnement

1. L’utilisateur se connecte  
2. Le serveur génère un **jeton JWT signé**
3. Le client appelle l’API avec :

```http
Authorization: Bearer <token>
Contenu du jeton
email

rôles

date d’expiration

Référence
https://jwt.io/

---

## Prochaines étapes
- API interne complète
- Module messagerie interne
- Espace admin complet (EasyAdmin)
- Tests unitaires / fonctionnels
- Calcul CO₂ amélioré
- Statistiques admin
- Intégration CI/CD Docker

## Améliorations backend
- Optimisation QueryBuilder
- Mise en cache (Redis)
- Services dédiés pour trajets

## Annexes techniques

## Problèmes Docker courants
| Problème | Solution |
|----------|----------|
| Certificats manquants | apt-get install ca-certificates |
| Mauvais chemin Apache | corriger le volume |
| Variables SCSS non chargées | utiliser `@use` au lieu de `@import` |
| Conflit Live Sass Compiler | désinstaller extension |

## Commandes utiles
```bash
docker compose up -d
symfony serve -d
symfony console cache:clear
npm run build

ecoride/
│
├── app/                        # Projet Symfony
│   ├── bin/
│   ├── config/
│   ├── public/
│   ├── src/
│   │   ├── Controller/
│   │   ├── Entity/
│   │   ├── Repository/
│   │   ├── Form/
│   │   ├── Security/
│   │   └── Service/
│   ├── templates/
│   ├── translations/
│   ├── dockerfile.dev
│   ├── dockerfile-prod
│   └── apache/
│       ├── default.conf
│       └── default-ssl.conf
│
├── compose.yaml                # docker-compose multi-services
├── mysql/                      # volume persistant MySQL
│
├── docs/                       # Documentation MkDocs
│   ├── index.md
│   ├── presentation.md
│   ├── environnement.md
│   ├── architecture.md
│   ├── frontend.md
│   ├── backend.md
│   ├── api.md
│   ├── securite.md
│   ├── roadmap.md
│   └── annexes.md
│
├── assets/                     # Front-end static assets
│   ├── js/
│   └── scss/
│
├── tests/                      # Tests PHPUnit
├── var/
├── vendor/
├── mkdocs.yml                  # Config MkDocs Material
└── README.md

---

## Aperçu du projet

![Diagramme Merise](Documents_README/images/Diagramme_Classe_Merise.png)
![Chutier couleur](Documents_README/images/chutier_couleur.jpg)
![Sirat](Documents_README/images/sirat-825x510.jpg)
![Home Page](Documents_README/images/HomePage.jpg)
![Covoiturages](Documents_README/images/covoiturages.jpg)
![Connexion](Documents_README/images/connexion.jpg)
![Connexion 2x](Documents_README/images/Connexion2x.png)
![iPhone SE 3 HomePage](Documents_README/images/iPhoneSE3_HomePage.jpg)
![Main Ecoride](Documents_README/images/main_ecoride.jpg)
![Palette photo](Documents_README/images/Palette_photo.jpg)