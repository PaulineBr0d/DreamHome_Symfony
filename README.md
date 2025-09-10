### Projet fil rouge du cours Symfony de la formation m2i.
Reprise et migration du projet PHP natif [Dream Home](https://github.com/PaulineBr0d/DreamHome) vers Symfony.

## Fonctionnalités principales

### Front Office
- Affichage des annonces par type (maison / appartement)
- Pagination des annonces
- Recherche filtrée (ville, prix, type de bien, transaction)
- Visualisation des annonces
- Ajout aux favoris (utilisateurs connectés)

### Authentification
- Inscription / Connexion / Déconnexion
- Gestion des sessions
- Redirection sécurisée

### Gestion des annonces
- Création d’annonces
- Modification / suppression (selon droits)
- Relations entre annonces, utilisateurs, type de bien, type de transaction

---

## Technologies

- **Symfony** (version 7.3.3)
- **Doctrine ORM**
- **Twig** pour les templates
- **PHP 8.4+**
- **MySQL**

## Améliorations

 - Ajouter une interface Admin avec formulaires sur types de transaction et propriété