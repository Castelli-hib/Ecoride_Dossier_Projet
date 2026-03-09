# Les actions REST (toujours les mêmes)

Action métier       Verbe HTTP      Exemple
Lister              GET             /api/route
Voir 1              GET             /api/route/42
Créer               POST            /api/route
Modifier            PUT / PATCH     /api/route/42
Supprimer           DELETE          /api/route/42

Le verbe HTTP dit l’action
L’URL dit la ressource

## API Ecoride

- users
- route
- reservation
- vehicles

### Définir les endpoints (contrat API)

GET      /api/route          → liste des trajets
GET      /api/route/{id}     → détail d’un trajet
POST     /api/route          → créer un trajet
PATCH    /api/route/{id}     → modifier un trajet
DELETE   /api/route/{id}     → supprimer un trajet

#### Définir les données échangées (JSON)

                 ┌──────────────┐
                 │   Ressource  │
                 │   ROUTE      │
                 └──────┬───────┘
                        │
        ┌───────────────┼────────────────┐
        │               │                │
     GET /api/route   POST /api/route   GET /api/route/{id}
        │               │                │
        ▼               ▼                ▼
  listRoute()     createRoute()        showRoute()
        │               │                │
        ▼               ▼                ▼
 RouteRepository   RoutetService      RouteRepository
        │               │
        ▼               ▼
   JSON[]        persist + validate
                        │
                        ▼
                    JsonResponse

Élément             Nom
-------------------|------------------
Entité Doctrine     Route
Repository          RouteRepository
Controller          RouteController
Endpoint API        /api/routes

Client (Postman / Front)
        │
        │ JSON
        ▼
Request Symfony
        │
        ▼
RouteController
        │
        ▼
Entité Route
        │
        ▼
Doctrine (persist / flush)
        │
        ▼
JsonResponse

## Architecture Dashboard Admin

╔═════════════╗
║ Symfony API ║
║ (JSON Data) ║
╚══════╦══════╝
       │
       ▼
╔═════════════════════╗
║ Fetch JS dans Twig  ║
║ (récupération des   ║
║ données depuis API) ║
╚══════╦══════════════╝
       │
       ▼
╔═════════════════════════╗
║ Template Twig            ║
║ (index.html.twig)        ║
║ Canvas pour Chart.js     ║
╚══════╦═══════════════════╝
       │
       ▼
╔═════════════════════╗
║ Chart.js            ║
║ (création graphiques║
║ dynamiques)         ║
╚══════╦══════════════╝
       │
       ▼
╔════════════════════════════════╗
║ Dashboard Admin (Vue finale)  ║
║ Graphiques par mois, ville,   ║
║ jour…                         ║
╚════════════════════════════════╝
