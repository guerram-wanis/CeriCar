# Projet : Cericar (Plateforme de Covoiturage)

## Présentation

Ce projet est une application Web de covoiturage. Elle permet la mise en relation entre conducteurs et passagers, la gestion des trajets, des véhicules, des réservations et des utilisateurs via une base de données MySQL.

Le projet repose sur une structure **MVC (Modèle-Vue-Contrôleur)** utilisant le framework PHP Yii2. 

## Technologies utilisées

- PHP 8+
- Framework Yii2
- HTML5 / CSS3 
- Bootstrap 5
- Composer (Gestionnaire de dépendances)

## Structure du projet

### Modèles (Données) :
- `voyage.php` : gestion des trajets proposés (villes, horaires, tarifs)
- `User.php` : gestion des comptes (conducteurs/passagers)
- `typevehicule.php` : gestion des voitures (type, ID)
- `marquevehicule.php` : gestion des voitures (marque, ID)
- `reservation.php` : gestion des réservations de places

### Contrôleurs (Logique) :
- `SiteController.php` : gestion des pages principales (Accueil, connexion, Deconnexion, s'enregistrer, prposer un voyage, profil, Contact, À propos)

### Vues (Interface) :
- `views/site/index.php` : page d'accueil
- `views/site/proposer.php` : formulaire de proposition de trajet (Style Glassmorphism)
- `views/layouts/main.php` : gabarit principal de l'application
- `web/css/site.css` : feuilles de style personnalisées (transparence, flou)

### Exécution
Lancer le serveur de développement PHP :

```bash
php yii serve

Projet réalisé par Guerram wanis (L3 Informatique - Groupe 1).