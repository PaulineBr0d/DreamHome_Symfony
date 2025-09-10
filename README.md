### Projet fil rouge du cours Symfony de la formation m2i.
Reprise et migration du projet PHP natif [Dream Home](https://github.com/PaulineBr0d/DreamHome) vers Symfony.

## Fonctionnalités principales

### Front Office
- Affichage des annonces par type (maison / appartement)
- Pagination des annonces
- Recherche filtrée (ville, prix, type de bien, transaction)
- Visualisation des annonces
- Ajout aux favoris (utilisateurs connectés)


### Gestion des annonces
- Création d’annonces
- Modification / suppression (selon droits)
- Relations entre annonces, utilisateurs, type de bien, type de transaction

---

## **#1 - Ajout de l’authentification et d’un espace d’administration**

### **1. Authentification**

- Mettre en place un système qui permet à un utilisateur de **s’inscrire** et de **se connecter**.
- Garantir la sécurité des mots de passe.
- Prévoir une interface adaptée selon que l’utilisateur est connecté ou non (affichage conditionnel des menus, etc …).

---

### **2. Partie Administration**

- Créer un **espace réservé uniquement aux administrateurs**.
- Dans cet espace, l’administrateur doit pouvoir gérer (CRUD):
    - Les types de transactions (vente, location, etc.)
    - Les types de biens (maison, appartement, terrain, etc.)
    - Les annonces immobilières (listings)
    - Les utilisateurs

---

### **3. Contraintes**

- Séparer clairement l’espace public (site accessible à tous) de l’espace d’administration.
- Mettre en place des règles d’accès : seuls les administrateurs peuvent entrer dans la partie admin.
- Proposer une navigation claire entre les différentes parties du site.


## Technologies

- **Symfony** (version 7.3.3)
- **Doctrine ORM**
- **Twig** pour les templates
- **PHP 8.4+**
- **MySQL**

