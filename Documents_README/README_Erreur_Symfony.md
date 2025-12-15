## ⚠️ Exceptions HTTP dans Symfony (Markdown)

Symfony utilise des exceptions spécifiques pour générer des **erreurs HTTP standardisées**. Ces classes étendent `HttpException` et permettent de retourner automatiquement un code HTTP avec un message explicite.

---

## 📋 Tableau récapitulatif des principales exceptions

| Exception Symfony                            | Code HTTP | Description courte                          |
|---------------------------------------------|-----------|----------------------------------------------|
| `NotFoundHttpException`                     | 404       | Ressource non trouvée                        |
| `AccessDeniedHttpException`                 | 403       | Accès interdit (droits insuffisants)         |
| `UnauthorizedHttpException`                 | 401       | Authentification nécessaire                  |
| `BadRequestHttpException`                   | 400       | Requête mal formulée                         |
| `MethodNotAllowedHttpException`             | 405       | Méthode HTTP non autorisée                   |
| `ConflictHttpException`                     | 409       | Conflit avec l'état actuel de la ressource   |
| `TooManyRequestsHttpException`              | 429       | Trop de requêtes (limite atteinte)           |
| `ServiceUnavailableHttpException`           | 503       | Service temporairement indisponible          |
| `GoneHttpException`                         | 410       | Ressource supprimée                          |
| `LengthRequiredHttpException`               | 411       | En-tête `Content-Length` requis              |
| `UnsupportedMediaTypeHttpException`         | 415       | Type de contenu non pris en charge           |
| `PreconditionFailedHttpException`           | 412       | Condition préalable échouée                  |
| `UnprocessableEntityHttpException`          | 422       | Entité bien formée mais non traitable        |
| `HttpException` *(classe générique)*        | Variable  | Exception personnalisée avec code HTTP       |

---
# 🌐 Tableau complet des codes d'erreur HTTP

| Code | Nom                           | Type                        | Signification / Utilisation typique                                      |
|------|-------------------------------|-----------------------------|---------------------------------------------------------------------------|
| 100  | `Continue`                      | Informationnel (1xx)        | Le client peut continuer la requête                                      |
| 101  | `Switching Protocols`           | Informationnel              | Le serveur accepte de changer de protocole                               |
| 102  | `Processing`                    | WebDAV                      | Requête en traitement (WebDAV)                                           |
| 103  | `Early Hints`                   | Préchargement               | Envoie des en-têtes précoces pour indiquer les ressources à précharger   |
| 200  | `OK`                            | Succès (2xx)                | Requête traitée avec succès                                              |
| 201  | `Created`                       | Succès                      | Une ressource a été créée                                                |
| 202  | `Accepted`                      | Succès                      | Requête acceptée mais non encore traitée                                 |
| 203  | `Non-Authoritative Information` | Succès                      | Informations retournées modifiées par un proxy                           |
| 204  | `No Content`                    | Succès                      | Requête traitée sans contenu à renvoyer                                  |
| 205  | `Reset Content`                 | Succès                      | Demande au client de réinitialiser le document (ex. formulaire)          |
| 206  | `Partial Content`               | Succès                      | Une partie seulement de la ressource est renvoyée                        |
| 207  | `Multi-Status`                  | WebDAV                      | Réponses multiples pour une seule requête                                |
| 208  | `Already Reported`              | WebDAV                      | Élément déjà listé dans une réponse précédente                           |
| 226  | `IM Used`                       | Expérimental                | Requête avec transformation Delta Encoding                               |
| 300  | `Multiple Choices`              | Redirection (3xx)           | Plusieurs réponses possibles (ex. pages multilingues)                    |
| 301  | `Moved Permanently`             | Redirection                 | Ressource déplacée de façon permanente                                   |
| 302  | `Found`                         | Redirection                 | Redirection temporaire (ex. après login)                                 |
| 303  | `See Other`                     | Redirection                 | Redirection vers une autre URL avec GET                                  |
| 304  | `Not Modified`                  | Redirection                 | Cache HTTP : la ressource n’a pas changé                                 |
| 305  | `Use Proxy`                     | Obsolète                    | Doit utiliser un proxy (non utilisé)                                     |
| 306  | `Switch Proxy`                  | Obsolète                    | Code réservé (inutilisé)                                                 |
| 307  | `Temporary Redirect`            | Redirection                 | Redirection temporaire sans changer la méthode HTTP                      |
| 308  | Permanent Redirect            | Redirection                 | Redirection permanente sans changer la méthode HTTP                      |
| 400  | Bad Request                   | Erreur client (4xx)         | Syntaxe invalide (ex. JSON mal formé, CSRF invalide)                     |
| 401  | Unauthorized                  | Erreur client               | Authentification requise                                                 |
| 402  | Payment Required              | Réservé                     | Prévu pour paiement futur                                                |
| 403  | Forbidden                     | Erreur client               | Accès refusé malgré authentification                                     |
| 404  | Not Found                     | Erreur client               | Ressource introuvable                                                    |
| 405  | Method Not Allowed            | Erreur client               | Méthode HTTP non autorisée                                               |
| 406  | Not Acceptable                | Erreur client               | Format de réponse non acceptable                                         |
| 407  | Proxy Authentication Required | Erreur client               | Authentification requise par un proxy                                    |
| 408  | Request Timeout               | Erreur client               | Délai d’attente de la requête dépassé                                    |
| 409  | Conflict                      | Erreur client               | Conflit avec l’état actuel de la ressource                               |
| 410  | Gone                          | Erreur client               | Ressource supprimée définitivement                                       |
| 411  | Length Required               | Erreur client               | En-tête Content-Length manquant                                          |
| 412  | Precondition Failed           | Erreur client               | Précondition HTTP non remplie                                            |
| 413  | Payload Too Large             | Erreur client               | Corps de la requête trop volumineux                                      |
| 414  | URI Too Long                  | Erreur client               | L’URL est trop longue                                                    |
| 415  | Unsupported Media Type        | Erreur client               | Type MIME non pris en charge                                             |
| 416  | Range Not Satisfiable         | Erreur client               | Plage de téléchargement invalide                                         |
| 417  | Expectation Failed            | Erreur client               | L’entête Expect a échoué                                                 |
| 418  | I'm a teapot                  | Blague RFC 2324             | Blague du protocole HTCPCP (avril 98)                                    |
| 421  | Misdirected Request           | Erreur client               | Requête envoyée au mauvais serveur                                       |
| 422  | Unprocessable Entity          | Erreur client               | Données valides mais erreur de validation (souvent API)                  |
| 423  | Locked                        | WebDAV                      | Ressource verrouillée                                                    |
| 424  | Failed Dependency             | WebDAV                      | Dépendance d’une requête échouée                                         |
| 425  | Too Early                     | Erreur client               | Requête envoyée trop tôt (TLS)                                           |
| 426  | Upgrade Required              | Erreur client               | Doit changer de protocole (ex. HTTP vers HTTPS)                          |
| 428  | Precondition Required         | Erreur client               | Précondition nécessaire (conflits concurrentiels)                        |
| 429  | Too Many Requests             | Erreur client               | Trop de requêtes (rate limiting)                                         |
| 431  | Request Header Fields Too Large| Erreur client              | En-tête HTTP trop volumineux                                             |
| 451  | Unavailable For Legal Reasons | Erreur client               | Censuré pour des raisons légales                                         |
| 500  | Internal Server Error         | Erreur serveur (5xx)        | Erreur interne non gérée                                                 |
| 501  | Not Implemented               | Erreur serveur              | Fonctionnalité non disponible                                            |
| 502  | Bad Gateway                   | Erreur serveur              | Erreur de la passerelle (proxy, reverse proxy)                           |
| 503  | Service Unavailable           | Erreur serveur              | Serveur surchargé ou en maintenance                                      |
| 504  | Gateway Timeout               | Erreur serveur              | Temps d’attente dépassé pour une passerelle                              |
| 505  | HTTP Version Not Supported    | Erreur serveur              | Version HTTP non supportée                                               |
| 506  | Variant Also Negotiates       | Erreur serveur              | Mauvaise configuration de négociation de contenu                         |
| 507  | Insufficient Storage          | WebDAV                      | Stockage insuffisant                                                     |
| 508  | Loop Detected                 | WebDAV                      | Boucle infinie détectée                                                  |
| 510  | Not Extended                  | Erreur serveur              | Extension HTTP requise                                                   |
| 511  | Network Authentication Required | Erreur serveur            | Authentification réseau requise (ex. portail captif)                     |

---


## 🚫 Exceptions HTTP dans Symfony

### Exemple de code
🔗 Ressources officielles
## Symfony : Custom Error Pages
## Symfony : HttpExceptionInterface

- **use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;**
- **throw new NotFoundHttpException('Cette page n’existe pas');**
---
## Exemples de fichiers :

- **error404.html.twig**
- **rror403.html.twig**
- **error500.html.twig**