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

### Système

- Windows 11 + WSL2 (Ubuntu ou Debian)
- Docker Desktop
- PHP 8.x / Composer
- Symfony CLI
- Node / npm / NVM
- VSCode

### Installation WSL2

```bash
wsl --install
sudo apt update && sudo apt upgrade -y
```

### Installation Docker

Docker Desktop avec backend WSL2

```bash
docker --version
docker compose version
```

### Installation Node via NVM

```bash
nvm use 20
```

### Installation du projet Symfony

```bash
symfony new app --webapp
composer install
```

---

## Architecture logicielle et Docker

### Conteneurs utilisés

| Service       | Rôle |
|---------------|------|
| app           | PHP / Symfony |
| mysql         | Base de données |
| phpmyadmin    | Interface SQL |
| mailhog       | Test SMTP |

### Arborescence projet

```
ecoride/
  app/
    dockerfile.dev
    apache/default.conf
  compose.yaml
  mysql/
```

---

## Front-end

### Technologies

- Bootstrap 5
- SCSS personnalisé
- Mobile-first → Desktop

### Composants prévus

- Header / Navbar
- Section Hero
- Cartes (trajets, conducteurs)
- Formulaires (inscription, recherche, réservation)
- Thème responsive conforme à la charte graphique

### Structure SCSS

```
assets/
  styles/
    base/
    components/
    layout/
    pages/
```

### Structure Symfony

```
src/
  Controller/
  Entity/
  Repository/
  Form/
  Security/
  Service/
```

### Entités existantes

- User
- Route
- Reservation
- Vehicle
- Preferences
- Brand
- Contact
- Avis

#### À ajouter

- Credit
- Litige

---

## Migrations

```bash
symfony console make:migration
symfony console doctrine:migrations:migrate
```

### Fixtures

```bash
composer require --dev orm-fixtures fakerphp/faker
symfony console doctrine:fixtures:load
```

### Objectifs Repository

- Recherche de trajets
- Réservations
- Profil utilisateur
- Gestion des véhicules
- Avis & litiges
- Messagerie interne

---

## JWT avec LexikJWTAuthenticationBundle

### Fonctionnement

1. L’utilisateur se connecte  
2. Le serveur génère un **jeton JWT signé**  
3. Le client appelle l’API avec :

```http
Authorization: Bearer <token>
```

Contenu du jeton :

- email
- rôles
- date d’expiration

Référence : [https://jwt.io/](https://jwt.io/)

---

## Prochaines étapes

- API interne complète
- Module messagerie interne
- Espace admin complet (EasyAdmin)
- Tests unitaires / fonctionnels
- Calcul CO₂ amélioré
- Statistiques admin
- Intégration CI/CD Docker

---

## Améliorations backend

- Optimisation QueryBuilder
- Mise en cache (Redis)
- Services dédiés pour trajets

---

## Annexes techniques

### Problèmes Docker courants

| Problème | Solution |
|----------|----------|
| Certificats manquants | apt-get install ca-certificates |
| Mauvais chemin Apache | corriger le volume |
| Variables SCSS non chargées | utiliser `@use` au lieu de `@import` |
| Conflit Live Sass Compiler | désinstaller extension |

---

## Commandes utiles

```bash
docker compose up -d
symfony serve -d
symfony console cache:clear
npm run build
```

### Structure globale du projet

```
ecoride/
├── app/
│   ├── bin/
│   ├── config/
│   ├── public/
│   ├── src/
│   ├── templates/
│   ├── translations/
│   ├── dockerfile.dev
│   ├── dockerfile-prod
│   └── apache/
├── compose.yaml
├── mysql/
├── docs/
├── assets/
├── tests/
├── var/
├── vendor/
├── mkdocs.yml
└── README.md
```

---

## Maquettes

Les maquettes sont disponibles sur [Figma](https://www.figma.com/design/cBeUm9wiFxE9pEoBkRrYgE/Ecoride_Wireframe?node-id=0-1&p=f&t=6eMbCQXzb5Z80TqD-0)

### Aperçu du projet

![Diagramme Merise](Documents_README/images/diagramme_classe_merise.png?raw=true)  
![Chutier couleur](Documents_README/images/chutier_couleur.jpg?raw=true)  
![Sirat](Documents_README/images/sirat-825x510.jpg?raw=true)  
![Homepage](Documents_README/images/homepage.jpg?raw=true)  
![Covoiturages](Documents_README/images/covoiturages.jpg?raw=true)  
![Connexion](Documents_README/images/connexion.jpg?raw=true)  
![Connexion2x](Documents_README/images/connexion2x.png?raw=true)  
![iPhone SE3 Homepage](Documents_README/images/iphonese3_homepage.jpg?raw=true)  
![Main Ecoride](Documents_README/images/main_ecoride.jpg?raw=true)  
![Palette photo](Documents_README/images/palette_photo.jpg?raw=true)  
![Covoiturage](Documents_README/images/covoiturage.jpg?raw=true)