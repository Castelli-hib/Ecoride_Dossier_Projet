# Spécifications Techniques Ecoride

## 1. Architecture Système

### 1.1 Architecture Globale

L'application Ecoride suit une architecture microservices avec les composants suivants :

```
┌──────────────────────────────────────────────────────────────────┐
│                         CLIENTS                                   │
├─────────────────────────┬────────────────────────────────────────┤
│    Application Web      │         Application Mobile             │
│      (React.js)         │         (React Native)                 │
└────────────┬────────────┴────────────────┬───────────────────────┘
             │                              │
             ▼                              ▼
┌──────────────────────────────────────────────────────────────────┐
│                      API GATEWAY (Nginx)                          │
└──────────────────────────────────────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────────────────────────┐
│                         SERVICES                                  │
├────────────────┬─────────────────┬───────────────────────────────┤
│   Auth Service │  Trajet Service │    Notification Service       │
├────────────────┼─────────────────┼───────────────────────────────┤
│   User Service │ Booking Service │    Payment Service            │
└────────────────┴─────────────────┴───────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────────────────────────┐
│                    COUCHE DE DONNÉES                              │
├────────────────┬─────────────────┬───────────────────────────────┤
│   PostgreSQL   │      Redis      │      Elasticsearch            │
│   (Principal)  │     (Cache)     │       (Recherche)             │
└────────────────┴─────────────────┴───────────────────────────────┘
```

### 1.2 Technologies Utilisées

| Composant | Technologie | Version | Justification |
|-----------|-------------|---------|---------------|
| Frontend Web | React.js | 18.x | Performances, écosystème riche |
| Frontend Mobile | React Native | 0.72.x | Code partagé, cross-platform |
| Backend | Node.js | 18.x LTS | Performances I/O, JavaScript unifié |
| Framework API | Express.js | 4.x | Flexibilité, middleware |
| Base de données | PostgreSQL | 15.x | Fiabilité, requêtes géospatiales |
| Cache | Redis | 7.x | Performances, sessions |
| Recherche | Elasticsearch | 8.x | Recherche full-text, géolocalisation |

## 2. Modèle de Données

### 2.1 Schéma Entité-Relation

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│    Users     │     │    Trips     │     │  Bookings    │
├──────────────┤     ├──────────────┤     ├──────────────┤
│ id (PK)      │────<│ driver_id(FK)│     │ id (PK)      │
│ email        │     │ id (PK)      │>────│ trip_id (FK) │
│ password     │     │ departure    │     │ user_id (FK) │
│ first_name   │     │ arrival      │     │ seats        │
│ last_name    │     │ date_time    │     │ status       │
│ phone        │     │ seats_avail  │     │ created_at   │
│ avatar_url   │     │ price        │     └──────────────┘
│ created_at   │     │ created_at   │
└──────────────┘     └──────────────┘
        │                   │
        ▼                   ▼
┌──────────────┐     ┌──────────────┐
│   Reviews    │     │   Messages   │
├──────────────┤     ├──────────────┤
│ id (PK)      │     │ id (PK)      │
│ author_id(FK)│     │ sender_id(FK)│
│ target_id(FK)│     │ recipient_id(FK) │
│ trip_id (FK) │     │ trip_id (FK) │
│ rating       │     │ content      │
│ comment      │     │ read_at      │
│ created_at   │     │ created_at   │
└──────────────┘     └──────────────┘
```

### 2.2 Tables Principales

#### Table Users
```sql
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    avatar_url TEXT,
    bio TEXT,
    rating_average DECIMAL(2,1) DEFAULT 0 CHECK (rating_average >= 0 AND rating_average <= 5),
    trips_count INTEGER DEFAULT 0,
    verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Table Trips
```sql
CREATE TABLE trips (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    driver_id UUID REFERENCES users(id),
    departure_city VARCHAR(100) NOT NULL,
    departure_address TEXT,
    departure_lat DECIMAL(10,8),
    departure_lng DECIMAL(11,8),
    arrival_city VARCHAR(100) NOT NULL,
    arrival_address TEXT,
    arrival_lat DECIMAL(10,8),
    arrival_lng DECIMAL(11,8),
    departure_time TIMESTAMP NOT NULL,
    seats_available INTEGER NOT NULL,
    price_per_seat DECIMAL(10,2) NOT NULL,
    vehicle_type VARCHAR(50),
    preferences JSONB,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 3. API REST

### 3.1 Endpoints Principaux

#### Authentification
| Méthode | Endpoint | Description |
|---------|----------|-------------|
| POST | `/api/auth/register` | Inscription utilisateur |
| POST | `/api/auth/login` | Connexion |
| POST | `/api/auth/logout` | Déconnexion |
| POST | `/api/auth/refresh` | Rafraîchir le token |
| POST | `/api/auth/password/reset` | Réinitialisation mot de passe |

#### Utilisateurs
| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/users/:id` | Obtenir profil utilisateur |
| PUT | `/api/users/:id` | Modifier profil |
| GET | `/api/users/:id/reviews` | Avis reçus |
| GET | `/api/users/:id/trips` | Trajets de l'utilisateur |

#### Trajets
| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/trips` | Rechercher des trajets |
| POST | `/api/trips` | Créer un trajet |
| GET | `/api/trips/:id` | Détails d'un trajet |
| PUT | `/api/trips/:id` | Modifier un trajet |
| DELETE | `/api/trips/:id` | Annuler un trajet |

#### Réservations
| Méthode | Endpoint | Description |
|---------|----------|-------------|
| POST | `/api/bookings` | Créer une réservation |
| GET | `/api/bookings/:id` | Détails réservation |
| PUT | `/api/bookings/:id/confirm` | Confirmer réservation |
| PUT | `/api/bookings/:id/cancel` | Annuler réservation |

### 3.2 Format des Réponses

```json
{
    "success": true,
    "data": {
        // Données de la réponse
    },
    "meta": {
        "page": 1,
        "per_page": 20,
        "total": 100
    }
}
```

### 3.3 Codes d'Erreur

| Code | Description |
|------|-------------|
| 200 | Succès |
| 201 | Ressource créée |
| 400 | Requête invalide |
| 401 | Non authentifié |
| 403 | Non autorisé |
| 404 | Ressource non trouvée |
| 422 | Erreur de validation |
| 500 | Erreur serveur |

## 4. Sécurité

### 4.1 Authentification

- Utilisation de JWT (JSON Web Tokens)
- Tokens d'accès avec durée de vie courte (15 min)
- Refresh tokens avec durée de vie longue (7 jours)
- Hashage des mots de passe avec bcrypt

### 4.2 Protection des Données

- Chiffrement TLS/SSL pour toutes les communications
- Validation et sanitisation de toutes les entrées
- Protection CSRF
- Rate limiting sur les endpoints sensibles
- Logs d'audit pour les actions critiques

### 4.3 Conformité RGPD

- Consentement explicite pour la collecte de données
- Droit d'accès et de portabilité des données
- Droit à l'effacement (droit à l'oubli)
- Minimisation des données collectées

## 5. Performance

### 5.1 Objectifs

| Métrique | Objectif |
|----------|----------|
| Temps de réponse API | < 200ms (P95) |
| Temps de chargement page | < 3s |
| Disponibilité | 99.9% |
| Requêtes simultanées | 1000+ |

### 5.2 Stratégies d'Optimisation

- Mise en cache Redis pour les requêtes fréquentes
- CDN pour les assets statiques
- Compression gzip/brotli
- Lazy loading des images
- Pagination des résultats

## 6. Déploiement

### 6.1 Environnements

| Environnement | Usage | URL |
|---------------|-------|-----|
| Développement | Tests locaux | localhost |
| Staging | Tests d'intégration | staging.ecoride.fr |
| Production | Application live | www.ecoride.fr |

### 6.2 CI/CD Pipeline

```
┌────────┐    ┌────────┐    ┌────────┐    ┌────────┐
│  Push  │───►│  Test  │───►│ Build  │───►│ Deploy │
│        │    │        │    │        │    │        │
└────────┘    └────────┘    └────────┘    └────────┘
                  │              │             │
                  ▼              ▼             ▼
              Unit Tests    Docker Image   Kubernetes
              Lint          Artifacts      Auto-scale
              Security
```

---

*Document technique Ecoride - Spécifications v1.0*
