# 📋 Récapitulatif des formulaires EcoRide

| Formulaire                     | Type Symfony                  | Utilisateur concerné     | Entité(s) associée(s)      |
|--------------------------------|-------------------------------|--------------------------|-----------------------------|
| **Inscription**                | `RegistrationFormType`        | Visiteur → Utilisateur   | User                        |
| **Connexion**                  | (géré par Security/Login)     | Utilisateur              | User (auth)                 |
| **Mot de passe oublié**        | `ResetPasswordRequestFormType`| Utilisateur              | User (email)                |
| **Réinitialisation mot de passe** | `ResetPasswordFormType`    | Utilisateur              | User (password)             |
| **Édition profil**             | `UserProfileFormType`         | Utilisateur              | User                        |
| **Ajout véhicule**             | `VehicleFormType`             | Conducteur               | Vehicle                     |
| **Modification véhicule**      | `VehicleFormType` (edit)      | Conducteur               | Vehicle                     |
| **Création trajet**            | `TripFormType`                | Conducteur               | Trip, Vehicle               |
| **Recherche trajet**           | `SearchTripFormType`          | Passager                 | Trip (filtre)               |
| **Réservation trajet**         | `BookingFormType`             | Passager                 | Booking, Trip, User         |
| **Annulation réservation**     | (action avec confirmation)    | Passager                 | Booking                     |
| **Paiement / Crédit**          | `PaymentFormType`             | Passager / Conducteur    | Payment, Wallet             |
| **Avis / Notation**            | `AddAvisFormType`              | Passager / Conducteur    | Review, Trip, User          |
| **Réclamation**                | `ComplaintFormType`           | Passager / Conducteur    | Complaint, User, Trip       |
| **Messagerie / Message**       | `MessageFormType`             | Utilisateurs (chat)      | Message, User               |
| **Gestion utilisateurs**       | `AdminUserFormType`           | Administrateur           | User                        |
| **Validation / suppression avis** | `AdminReviewFormType`      | Administrateur / Employé | Review                      |
| **Gestion offres & promotions**| `PromoFormType`               | Gestionnaire / Admin     | Promo                       |

---

## Priorité minimale (MVP)

- Inscription = fait
- Connexion  = fait
- Mot de passe oublié  = fait
- Réinitialisation mot de passe  = fait
- Édition profil  = fait
- Ajout véhicule  
- Création trajet  = fait
- Recherche trajet  
- Réservation trajet  
- Paiement  

➡️ **10 formulaires indispensables**  

## 🔥 Fonctionnalités avancées

- Avis / Réclamations  = en cours
- Messagerie  
- Administration (user, avis, promos)  

➡️ **+8 formulaires** (selon roadmap)  
