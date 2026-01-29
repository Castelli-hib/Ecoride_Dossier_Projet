# Principe général

Chart.js ne parle pas à Doctrine
Chart.js ne parle pas à Symfony

Chart.js lit du JavaScript
Symfony fournit des données (Twig ou JSON)

**Le schéma est**
Repository → Controller → Twig (data) → JS → Chart.js

## Schéma logique du dashboard Admin

**Un dashboard Admin sert à regrouper des statistiques globales.**
Statistique                             Source                      Exemple
--------------------------------------|---------------------------|--------
Nombre de trajets                       RouteRepository             120
Nombre de réservations                  ReservationRepository       350
Taux de confirmation global             ReservationRepository       85 %
Moyenne des notes (avis)                AvisRepository              4,2
Flux de crédits                         CreditRepository            +450 € / -120 €
Activité par période                    ReservationRepository       Jour/Semaine

## Ordre conseillé

Repository          → chiffres fiables
Twig                → affichage brut
Vérification        → chiffres corrects
Ajouter Chart.js    → visualisation graphique
