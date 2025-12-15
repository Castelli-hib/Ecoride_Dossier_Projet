
# Commandes Bash essentielles pour Symfony

Ce document récapitule les commandes Bash les plus utiles pour développer avec Symfony (version 6 ou 7).

---

## 1. Création du projet Symfony

### Projet complet (avec Twig, Doctrine, etc.)

symfony new nom_du_projet --webapp

### Projet minimal

symfony new nom_du_projet

## 2. Lancer le serveur local Symfony

symfony serve

### En arrière-plan

symfony serve -d

### Arrêter le serveur

symfony server:stop

## 3. Installer des composants

### Exemple avec Doctrine + annotations + Twig

composer require symfony/orm-pack
composer require annotations
composer require twig

## 4. Créer une entité

php bin/console make:entity

## 5. Gérer la base de données

### Créer la base

php bin/console doctrine:database:create

### Générer une migration

php bin/console make:migration

### Appliquer une migration

php bin/console doctrine:migrations:migrate

---

## 6. Créer un contrôleur

php bin/console make:controller NomController

## 7. Créer un formulaire

php bin/console make:form

---

## 8. Mettre en place une authentification

composer require symfony/security-bundle
php bin/console make:user
php bin/console make:auth

## 9. Lancer les tests PHPUnit

php bin/phpunit

---

## 10. Nettoyer le cache

php bin/console cache:clear

## 11. Debug et vérification

### Voir les routes

php bin/console debug:router

### Voir les services

php bin/console debug:container

### Voir la configuration

php bin/console debug:config

## Notes

- Toutes les commandes doivent être lancées à la racine du projet.
- Composer doit être installé : [getcomposer.org](https://getcomposer.org/)
- L'outil `symfony` est requis : [symfony.com/download](https://symfony.com/download)

## Git essaie de garder une cohérence entre les systèmes d’exploitation

- il stocke les fichiers en LF dans le dépôt Git (pour la compatibilité Linux)

- il les convertit en CRLF sur ton poste Windows pour que ton éditeur (VS Code, etc.) les lise correctement.il les convertit en CRLF sur ton poste Windows pour que ton éditeur (VS Code, etc.) les "lise correctement.

## git add --renormalize espace et point

---
