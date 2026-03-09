# Sécurité & Acronymes Clés – Projet Ecoride (Symfony)

## Attaques et Protections

| Acronyme              | Signification                         | Type        | Risque                          | Protection dans Symfony |
|-----------------------|---------------------------------------|-------------|---------------------------------|-------------------------|
| **SQL Injection**     | Structured Query Language Injection   | Attaque BDD | Injection requêtes malveillantes| **Doctrine ORM**(requêtes préparées automatiques) |
| **XSS**               | Cross-Site Scripting                  | Attaque Front | Injection de script JS dans les pages | **Twig** (échappement automatique `{{ }}`) |
| **CSRF**  | Cross-Site Request Forgery | Attaque Formulaire | Exécution d'action à l'insu de l'utilisateur | **CSRF Token Symfony** (`{{ csrf_token() }}`) |
| **CORS**  | Cross-Origin Resource Sharing | Politique sécurité navigateur | Blocage / fuite API | Configuration `cors.yaml` |
| **JWT**   | JSON Web Token | Authentification API | Vol / falsification token | Signature + expiration |
| **HTTPS** | HyperText Transfer Protocol Secure | Transport sécurisé | Interception données | Certificat SSL |

---

## Acronymes essentiels à retenir

### Méthodologie Projet

| Acronyme  | Signification                          | Utilité dans Ecoride              |
|-----------|----------------------------------------|-----------------------------------|
| **UML**   | Unified Modeling Language              | Diagramme de classes et séquence  |
| **MVC**   | Model View Controller                  | Architecture Symfony              |
| **CRUD**  | Create Read Update Delete              | EasyAdmin + entités               |
| **API**   | Application Programming Interface      | `/api/admin/stats`                |
| **RGPD**  | Règlement Général Protection Données   | Gestion données utilisateurs      |
| **BDD**   | Base de Données                        | MySQL + futur MongoDB             |
| **MCD**   | Modèle Conceptuel de Données           | Structure relationnelle           |
| **CI/CD** | Continuous Integration / Deployment    | Git + déploiement                 |

### Développement Technique

| Acronyme  | Signification                     | Utilité dans Ecoride      |
|-----------|-----------------------------------|---------------------      |
| **ORM**   | Object Relational Mapping         | Doctrine                  |
| **ODM**   | Object Document Mapping           | MongoDB                   |
| **DTO**   | Data Transfer Object              | Structuration API         |
| **REST**  | Representational State Transfer   | API JSON                  |
| **JSON**  | JavaScript Object Notation        | Réponse API               |
| **AJAX**  | Asynchronous JS And XML           | `fetch()` pour dashboard  |
| **SSR**   | Server Side Rendering             | Twig                      |
| **SPA**   | Single Page Application           | (évolution future)        |
| **CLI**   | Command Line Interface            | `symfony console`         |
| **ENV**   | Environnement (dev, prod)         | `.env`                    |

---

## Synthèse Sécurité Dashboard Admin

- **Doctrine ORM**          → protège contre SQL Injection  
- **Twig**                  → protège contre XSS  
- **CSRF Token**            → protège les formulaires  
- **Architecture MVC**      → séparation logique front/back  
- **API REST JSON**         → communication propre front/back  
- **Chart.js + fetch()**    → dashboard dynamique

### Mini Schéma

**flowchart TD**
Utilisateur     --> Formulaire[Twig + CSRF]
Formulaire      --> Controller[MVC Controller]
Controller      --> BDD[Doctrine ORM]
BDD             --> SQL[Base SQL]
API             --> JSON[JSON]
JSON            --> Fetch[fetch()]
Fetch           --> Chart[Chart.js Dashboard]

#### ecoride Symfony – Mémo Sécurité & Acronymes

**Attaques → Protection**
SQL Injection → Doctrine ORM
XSS → Twig ({{ }})
CSRF → CSRF Token
CORS → cors.yaml
JWT → Signature + expiration
HTTPS → SSL

**Méthodo / Projet**
UML     → diagrammes
MVC     → architecture Symfony
CRUD    → EasyAdmin + entités
API     → /api/admin/stats
RGPD    → protection données
BDD     → MySQL / MongoDB
MCD     → structure relationnelle
CI/CD   → Git + déploiement

*Technique / Dev*
ORM → Doctrine
ODM → MongoDB
DTO → structurer API
REST → API JSON
JSON → réponse API
AJAX → fetch()
SSR → Twig
SPA → futur front JS
CLI → symfony console
ENV → .env

##### Sécurité : Attaques & Protections dans Symfony

**Acronyme : SQL Injection**
Signification : Structured Query Language Injection
Type : Attaque BDD|Injection de requêtes malveillantes
Risque : Doctrine ORM (requêtes préparées automatiques)

**Acronyme : XSS**
Signification : Cross-Site Scripting
Type : Attaque Front
Risque : Injection de script JS dans les pages Twig (échappement automatique {{ }})

**Acronyme : CSRF**
Signification : Cross-Site Request Forgery
Type : Attaque Formulaire Exécution d'action à l'insu de l'utilisateur
Risque : CSRF Token Symfony ({{ csrf_token() }})

**Acronyme : CORS**
Signification : Cross-Origin Resource Sharing
Type : Politique sécurité navigateur
Risque : Blocage / fuite API Configuration cors.yaml

**Acronyme : JWT**
Signification : JSON Web Token
Type : Authentification API
Risque : Vol / falsification token Signature + expiration

A**cronyme : HTTPS**
Signification : HyperText Transfer Protocol Secure
Type : Transport sécurisé
Interception données
Certificat SSL

##### Acronymes essentiels à retenir (Méthodologie + Dev Symfony)

Méthodologie Projet (Ecoride)
Acronyme                Signification                           Utilité dans ton projet
UML                     Unified Modeling Language               Diagramme de classes, séquence
MVC                     Model View Controller                   Architecture Symfony
CRUD                    Create Read Update Delete               EasyAdmin + entités
API                     Application Programming Interface       /api/admin/stats
RGPD                    Règlement Général Protection Données    Gestion données utilisateurs
BDD                     Base de Données	MySQL + futur MongoDB
MCD                     Modèle Conceptuel de Données            Structure relationnelle
CI/CD                   Continuous Integration / Deployment     Git + déploiement

##### Développement Technique (Symfony / Ecoride)

Acronyme                Signification                           Où dans ton projet
ORM                     Object Relational Mapping               Doctrine
ODM                     Object Document Mapping                 MongoDB
DTO                     Data Transfer Object                    Structuration API
REST                    Representational State Transfer         API JSON
JSON                    JavaScript Object Notation              Réponse API
AJAX                    Asynchronous JavaScript And XML         fetch()
SSR                     Server Side Rendering                   Twig
SPA                     Single Page Application                 (si évolution future)
CLI                     Command Line Interface                  symfony console
ENV                     Environnement (dev, prod)               .env

**Dans Ecoride, la sécurité repose sur :**

Doctrine (ORM)      → protège contre SQL Injection
Twig                → protège contre XSS
Token CSRF          → protège les formulaires
Architecture MVC    → séparation logique
API REST JSON       → communication propre front/back
Chart.js + fetch()  → dashboard dynamique
