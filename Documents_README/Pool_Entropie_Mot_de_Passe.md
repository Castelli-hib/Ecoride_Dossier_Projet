# Pool de caractères et entropie des mots de passe

## Qu’est-ce que le pool de caractères ?

Le **pool de caractères** correspond à l’ensemble des caractères que le mot de passe peut contenir.  
Plus le pool est **grand**, plus le mot de passe est **difficile à deviner**.

### Catégories classiques

| Catégorie    | Exemples          | Taille |
|-------------|-------------------|--------|
| Minuscules  | a-z               | 26     |
| Majuscules  | A-Z               | 26     |
| Chiffres    | 0-9               | 10     |
| Symboles    | !@#$%^&*()_+ etc. | ~32    |

> Exemple : un mot de passe utilisant minuscules + chiffres → pool = 26 + 10 = 36 caractères possibles.

---

## Calcul de l’entropie

L’entropie mesure la **force d’un mot de passe** en bits.

**Formule :**

Entropie (bits) = log2(pool^longueur)

- **pool** = nombre de caractères possibles  
- **longueur** = nombre de caractères du mot de passe

### Exemple concret

Mot de passe : `Ab3$`  

- Pool = 26 (minuscules) + 26 (majuscules) + 10 (chiffres) + 32 (symboles) = 94

- Longueur = 4  

Entropie :

Entropie = log2(94^4) ≈ 26.25 bits


---

## Pourquoi c’est important

1. **Protection contre la force brute**  
   - Plus le pool est grand → plus de combinaisons → plus de temps nécessaire pour casser le mot de passe.  
2. **Protection contre les attaques par dictionnaire**  
   - Les mots courants ou schémas simples ont une entropie faible.  
3. **Résilience si la base de données est compromise**  
   - Un mot de passe à forte entropie rend le cassage des hash beaucoup plus long, même avec du matériel puissant.

---

## Calcul pratique du pool (algorithme simple)

Pour estimer le pool d’un mot de passe :

1. Vérifier la présence de minuscules → ajouter 26 si présentes.
2. Vérifier la présence de majuscules → ajouter 26 si présentes.  
3. Vérifier la présence de chiffres → ajouter 10 si présents.  
4. Vérifier la présence de symboles → ajouter ~32 si présents.  

```js
function estimatePool(password) {
  let pool = 0;
  if (/[a-z]/.test(password)) pool += 26;
  if (/[A-Z]/.test(password)) pool += 26;
  if (/[0-9]/.test(password)) pool += 10;
  if (/[^a-zA-Z0-9]/.test(password)) pool += 32; // approximation
  return pool;
}

function entropy(password) {
  const pool = estimatePool(password);
  if (pool === 0) return 0;
  return Math.log2(Math.pow(pool, password.length));
}
```

> Remarque : cette méthode **approxime** le pool. Dans la réalité, certains symboles ou jeux de caractères peuvent varier selon l’encodage et l’alphabet utilisé.

---

## 5️⃣ Exemples comparatifs

| Mot de passe       | Pool | Longueur | Entropie (approx.) | Interprétation |
|-------------------|------|----------|--------------------:|----------------|
| `abcd`             | 26   | 4        | ~18.8 bits         | Faible ⚠️      |
| `Ab3$`             | 94   | 4        | ~26.3 bits         | Moyen ⚙️       |
| `qT7#Lz@R9pK3`     | 94   | 12       | ~78 bits           | Très forte 🔒  |

---

## Conseils pratiques

- **Allonger** le mot de passe est souvent plus efficace que multiplier les règles.  
- Favoriser les **passphrases** (suite de mots) pour une bonne ergonomie + haute entropie.  
- Utiliser un **gestionnaire de mots de passe** pour générer et stocker des mots de passe uniques et longs.  
- Éviter les mots du dictionnaire, les dates ou schémas personnels faciles à deviner.

---

## Références rapides

- Approche simple basée sur la théorie de l'information (entropie en bits).  
- Méthodes plus avancées (zxcvbn, estimation par pattern) existent pour évaluer la résistance réelle d’un mot de passe.  

Constante                    Signification
STRENGTH.VERY_WEAK           Très faible     – le mot de passe est facilement devinable
STRENGTH.WEAK                Faible          – faible sécurité, risque d’attaque simple
STRENGTH.MEDIUM              Moyen           – acceptable mais pourrait être amélioré
STRENGTH.STRONG              Fort            – bon niveau de sécurité
STRENGTH.VERY_STRONG         Très fort       – mot de passe complexe et sécurisé

## https://www.pleacher.com/mp/mlessons/algebra/entropy.html

## https://rumkin.com/tools/password/

## https://owasp.org/www-project-top-ten/