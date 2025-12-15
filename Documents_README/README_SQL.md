# Mémo SQL

## 1. Création et suppression de bases de données

```sql
CREATE DATABASE nom_de_la_base;
DROP DATABASE nom_de_la_base;
2. Utilisation d’une base
sql
Copier le code
USE nom_de_la_base;
3. Gestion des tables
sql
Copier le code
-- Créer une table
CREATE TABLE nom_table (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    age INT,
    date_inscription DATE
);

-- Supprimer une table
DROP TABLE nom_table;

-- Modifier une table
ALTER TABLE nom_table
ADD COLUMN email VARCHAR(100);

ALTER TABLE nom_table
DROP COLUMN age;

4. Manipulation des données

-- Insérer des données
INSERT INTO nom_table (nom, age, date_inscription)
VALUES ('Alice', 25, '2025-09-01');

-- Mettre à jour
UPDATE nom_table
SET age = 26
WHERE nom = 'Alice';

-- Supprimer
DELETE FROM nom_table
WHERE nom = 'Alice';

-- Sélectionner
SELECT * FROM nom_table;
SELECT nom, age FROM nom_table WHERE age > 20;
SELECT DISTINCT nom FROM nom_table;
SELECT * FROM nom_table ORDER BY age DESC;
SELECT * FROM nom_table LIMIT 5;

5. Fonctions et agrégats

SELECT COUNT(*) FROM nom_table;
SELECT SUM(age) FROM nom_table;
SELECT AVG(age) FROM nom_table;
SELECT MAX(age), MIN(age) FROM nom_table;

6. Jointures

-- Inner Join
SELECT *
FROM table1
INNER JOIN table2
ON table1.id = table2.table1_id;

-- Left Join
SELECT *
FROM table1
LEFT JOIN table2
ON table1.id = table2.table1_id;

7. Contraintes

-- Clé primaire
PRIMARY KEY (id)

-- Clé étrangère
FOREIGN KEY (colonne) REFERENCES table_cible(colonne_cible)

-- Unicité
UNIQUE (email)

-- Non nul
NOT NULL
8. Index

CREATE INDEX idx_nom ON nom_table(nom);
DROP INDEX idx_nom ON nom_table;

9. Transactions

START TRANSACTION;
-- commandes SQL
COMMIT; -- valider
ROLLBACK; -- annuler

10. Sauvegarde et restauration

-- Sauvegarde MySQL
mysqldump -u utilisateur -p nom_base > backup.sql

