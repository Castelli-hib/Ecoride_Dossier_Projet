# Importance de l’entropie du mot de passe et sécurité

## 1. Qu’est-ce que l’entropie d’un mot de passe ?

L’**entropie** (mesurée en **bits**) représente la quantité d’information nécessaire pour deviner un mot de passe.  

- Plus elle est **élevée**, plus le mot de passe est imprévisible.
- Plus elle est **basse**, plus il est **facile à deviner**.

> **Formule simplifiée :**  
> Entropie = log₂(nombre_total_de_combinaisons_possibles)

---

## 🧮 2. Exemple concret

| Type de mot de passe | Longueur | Caractères possibles | Entropie (approx.) | Niveau de sécurité |
|----------------------|-----------|-----------------------|--------------------|--------------------|
| `azerty`             | 6         | 26 lettres            | ~28 bits           | Très faible       |
| `Azerty1`            | 7         | 62 caractères         | ~42 bits           | Moyen |
| `Aze$1tY7!`          | 8         | 94 caractères (tous)  | ~52 bits           | Bon   |
| `qT7#Lz@R9pK3`       | 12        | 94 caractères          | ~78 bits           | Excellent  |

---

##  3. Pourquoi c’est important pour la sécurité

### a- Protection contre les attaques par force brute

Les hackers testent des **milliards de combinaisons par seconde**.  
➡️ Une **haute entropie** rend le mot de passe **impossible à casser rapidement**.

### b-Protection contre les attaques par dictionnaire

Un mot courant ou un modèle simple (`Motdepasse123`, `Thoms2024!`) a une **entropie faible**.

### c - Meilleure résistance même si la base de données est compromise

Si un mot de passe hashé est volé, une **forte entropie** rend sa **reconstitution quasi impossible**.

---

## 🧩 4. Lien avec les validations front-end

En front-end, on peut estimer l’entropie :

- en détectant les **types de caractères** (minuscules, majuscules, chiffres, symboles) ;
- en tenant compte de la **longueur** ;
- et en affichant une **barre de force visuelle** (rouge → vert).

Cela permet d’**éduquer l’utilisateur** et de **renforcer la sécurité** sans contraintes excessives.

---

## 5. Résumé simple

| Faible entropie | Haute entropie |
|-----------------|----------------|
| Facile à retenir, facile à casser | Difficile à deviner, très sûr |
| Mots courants, schémas simples | Mélange varié et long |
| Risque élevé de piratage | Protection durable même si hash volé |

## 6. pour aller plus loin

https://www.pleacher.com/mp/mlessons/algebra/entropy.html
https://owasp.org/www-project-top-ten/
