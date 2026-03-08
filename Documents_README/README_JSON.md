# Sommaire

Définition du JSON
Caractéristiques essentielles du JSON
Utilisations courantes en développement web

JSON dans un projet Symfony

Comparaison JSON / XML

Équivalences JSON ↔ PHP ↔ JavaScript

Flux typique d’une application web

Fiche ultra-synthèse — JSON / API / AJAX

Exemple concret — Symfony + fetch JavaScript (Ecoride)

Lien avec les compétences RNCP

1. Définition du JSON

JSON (JavaScript Object Notation) est un format de texte utilisé pour structurer et échanger des données entre applications.

👉 En très simple :

JSON = une façon standard d’écrire des données pour que le serveur et le navigateur se comprennent.

Il est :

indépendant du langage

lisible par l’humain

facilement interprété par les machines

Définition (RNCP)

Le JSON est un format standardisé de représentation de données basé sur une structure clé / valeur, utilisé pour les échanges entre un client (front-end) et un serveur (back-end).

2. Caractéristiques essentielles du JSON
Structure

Un JSON est composé de :

objets { }

tableaux [ ]

clé : valeur

Types de données possibles

string → "Marie"

number → 1

boolean → true / false

null

object → { }

array → [ ]

Exemple simple
{
  "id": 1,
  "firstname": "Marie",
  "lastname": "Castelli",
  "roles": ["ROLE_USER", "ROLE_DRIVER"],
  "active": true
}


👉 Lecture simple :

"firstname" = le nom du champ

"Marie" = la valeur

Comme une fiche :

clé        valeur
nom    →   Castelli
id     →   1

3. Utilisations courantes en développement web

Le JSON sert principalement à :

échanger des données via des API REST

faire communiquer le front et le back

stocker temporairement des données

fichiers de configuration

Exemple concret :

Symfony envoie une liste de trajets

JavaScript l’affiche sans recharger la page

4. JSON dans un projet Symfony

Dans Symfony, JSON est utilisé pour :

réponses d’API (JsonResponse)

endpoints AJAX

APIs REST

Exemple
return $this->json([
    'status' => 'success',
    'data' => $routes
]);


👉 Symfony transforme automatiquement le tableau PHP en JSON.

Différence avec un objet PHP
PHP	JSON
Tableau / Objet	Format texte
Utilisé côté serveur	Utilisé pour l’échange
Interne à PHP	Standard universel
5. Comparaison JSON / XML
Critère	JSON	XML
Type	Format de données	Langage de balisage
Lisibilité	Très lisible	Plus verbeux
Syntaxe	Clé / valeur	Balises
Poids	Léger	Plus lourd
Parsing	Rapide	Plus complexe
Usage principal	APIs REST	SOAP, config
Support JS	Oui	Non
Usage actuel	Majoritaire	En recul
Exemple équivalent
JSON
{
  "user": {
    "id": 1,
    "email": "user@ecoride.fr"
  }
}

XML
<user>
    <id>1</id>
    <email>user@ecoride.fr</email>
</user>


✅ Conclusion : JSON est aujourd’hui le standard des applications web modernes.

6. Équivalences JSON ↔ PHP ↔ JavaScript

Même donnée, écrite différemment selon le langage.

JSON (échange)
{
  "id": 1,
  "email": "driver@ecoride.fr",
  "roles": ["ROLE_USER", "ROLE_DRIVER"]
}

PHP (Symfony — back-end)
$data = [
    'id' => 1,
    'email' => 'driver@ecoride.fr',
    'roles' => ['ROLE_USER', 'ROLE_DRIVER']
];

$json = json_encode($data);
$array = json_decode($json, true);


👉 PHP travaille avec des tableaux, puis les convertit en JSON.

JavaScript (front-end)
const data = {
  id: 1,
  email: "driver@ecoride.fr",
  roles: ["ROLE_USER", "ROLE_DRIVER"]
};

const obj = JSON.parse(jsonString);
const json = JSON.stringify(data);


👉 JavaScript reçoit le JSON et le transforme en objet utilisable.

7. Flux typique en application web

Étapes normales :

Le back-end Symfony récupère les données en base

Il renvoie ces données en JSON

Le front-end JavaScript reçoit le JSON

Les données sont affichées dans la page

👉 Image mentale simple :

Base de données
      ↓
Symfony (PHP)
      ↓ JSON
JavaScript (navigateur)
      ↓
Affichage utilisateur

8. Fiche ultra-synthèse — JSON / API / AJAX
JSON

format standard d’échange de données

structure clé / valeur

utilisé entre front et back

API

interface de communication entre applications

expose des endpoints

utilise HTTP (GET, POST, PUT, DELETE)

échange des données en JSON

AJAX

communication avec le serveur sans recharger la page

appels asynchrones

souvent via fetch()

Relation entre les trois

👉 L’API fournit des données en JSON, récupérées côté front via AJAX.

9. Exemple concret — Symfony + fetch JavaScript (Ecoride)
1️⃣ Back-end Symfony (API JSON)
#[Route('/api/routes', name: 'api_routes', methods: ['GET'])]
public function routes(): JsonResponse
{
    return $this->json([
        ['id' => 1, 'departure' => 'Ajaccio', 'arrival' => 'Bastia'],
        ['id' => 2, 'departure' => 'Corte', 'arrival' => 'Calvi']
    ]);
}


👉 Symfony envoie une liste de trajets en JSON.

2️⃣ Front-end JavaScript (AJAX)
fetch('/api/routes')
  .then(response => response.json())
  .then(data => {
    data.forEach(route => {
      console.log(`${route.departure} → ${route.arrival}`);
    });
  });


👉 JavaScript récupère les données et les affiche.

Ce que démontre cet exemple

création d’un endpoint API

retour de données JSON

appel AJAX

séparation front / back

10. Lien explicite avec les compétences RNCP

Bloc : Développement et intégration d’applications web

Compétences mises en œuvre :

concevoir une API REST

structurer et échanger des données au format JSON

mettre en œuvre des appels AJAX

assurer la communication front-end / back-end

respecter la séparation des responsabilités

Formulation orale (Ecoride)

Dans le projet Ecoride, les données sont échangées via une API REST Symfony au format JSON. Le front-end consomme ces données en AJAX avec fetch afin d’afficher dynamiquement les trajets.