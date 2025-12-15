
# Filtres Twig – Guide complet

Twig est le moteur de templates utilisé par Symfony. Les **filtres** permettent de **modifier ou formater une variable** directement dans le template.

---

## 🔹 Syntaxe de base

```twig
{{ variable|filtre }}
```

Certains filtres acceptent des **arguments** :

```twig
{{ variable|filtre(argument1, argument2) }}
```

---

## 🔧 Filtres courants

| **Filtre**         | **Description**                                               | **Exemple** |
|--------------------|---------------------------------------------------------------|-------------|
| `capitalize`        | Met en majuscule la première lettre                          | `{{ 'bonjour'&#124;capitalize }}` → `Bonjour` |
| `upper`             | Met tout en majuscule                                       | `{{ 'bonjour'&#124;upper }}` → `BONJOUR` |
| `lower`             | Met tout en minuscule                                       | `{{ 'BONJOUR'&#124;lower }}` → `bonjour` |
| `title`             | Majuscule sur chaque mot                                    | `{{ 'salut le monde'&#124;title }}` → `Salut Le Monde` |
| `length`            | Donne la longueur (caractères ou éléments d’un tableau)     | `{{ 'abcde'&#124;length }}` → `5` |
| `date`              | Formate une date                                             | `{{ myDate&#124;date('d/m/Y') }}` |
| `number_format`     | Formate un nombre avec séparateur                           | `{{ 12345.678&#124;number_format(2, ',', ' ') }}` → `12 345,68` |
| `join`              | Concatène les éléments d’un tableau                         | `{{ ['a', 'b', 'c']&#124;join(', ') }}` → `a, b, c` |
<!-- | `replace`           | Remplace une chaîne par une autre                           | `{{ 'Bonjour'&#124;replace({'jour': 'soir'}) }}` → `Bonsoir` | -->
| `default`           | Valeur par défaut si vide ou nul                            | `{{ nom&#124;default('Inconnu') }}` |
| `trim`              | Supprime les espaces autour                                 | `{{ '  Hello  '&#124;trim }}` → `Hello` |
| `nl2br`             | Remplace les `\n` par des `<br>`                            | `{{ texte&#124;nl2br }}` |
| `json_encode`       | Encode en JSON                                               | `{{ variable&#124;json_encode }}` |
| `merge`             | Fusionne deux tableaux                                       | `{{ [1, 2]&#124;merge([3, 4]) }}` → `[1, 2, 3, 4]` |
| `sort`              | Trie un tableau                                              | `{{ [3, 1, 2]&#124;sort }}` → `[1, 2, 3]` |
| `reverse`           | Inverse un tableau ou une chaîne                            | `{{ 'abc'&#124;reverse }}` → `cba` |
| `keys`              | Retourne les clés d’un tableau                              | `{{ {'a': 1, 'b': 2}&#124;keys }}` → `['a', 'b']` |
| `escape`            | Protège les caractères HTML                                 | `{{ '<strong>'&#124;escape }}` → `&lt;strong&gt;` |
| `e` (alias de escape) | Idem que `escape`                                         | `{{ texte&#124;e }}` |
| `raw`               | Affiche du HTML sans échappement                            | `{{ texte&#124;raw }}` *(⚠️ Attention à la sécurité)* |

---

## 📍 Filtres utiles avec les **dates**

```twig
{{ post.publishedAt|date('d/m/Y H:i') }}
{{ birthday|date('l, F jS') }} {# lundi, avril 22 #}
```

---

## ✅ Astuce : Combinaison de filtres

```twig
{{ user.name|upper|replace({'É': 'E'}) }}
```

---

## 🔐 Sécurité : raw vs escape

- `escape` ou `e` : protège contre l'injection HTML ou XSS.
- `raw` : désactive la protection. À **éviter sauf si sûr de la source**.
