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

## **#2 - Fonctionnalité « Favoris »**

### **1. Accès & périmètre**

- La fonctionnalité est réservée aux **utilisateurs connectés**.
- Les favoris sont **personnels** (un utilisateur ne voit que ses favoris).

### **2. Actions attendues**

- **Ajouter** une annonce aux favoris depuis la page liste et/ou la page détail.
- **Retirer** une annonce de ses favoris depuis les mêmes écrans.
- **Consulter la liste** de ses favoris dans un espace dédié (ex. “Mes favoris”).
- **Signaler visuellement** qu’une annonce est déjà dans les favoris.

### **3. Contraintes & UX**

- L’interface doit indiquer clairement l’état : favori / non favori.
- Les actions doivent donner un **retour utilisateur** (message de confirmation).

## **#3 - Mise en place d’un espace Agent pour la gestion des annonces**

### **1. Accès et rôles**

- Créer un espace réservé aux **Agents**, accessible uniquement aux utilisateurs possédant le rôle ROLE_AGENT.
- Séparer clairement l’espace public (visiteurs), l’espace Admin (gestion globale), et l’espace Agent (gestion individuelle).
- Vérifier que les agents n’ont pas accès à l’administration générale.

---

### **2. Espace Agent**

- Proposer un **tableau de bord** qui présente un résumé des annonces de l’agent.
- Ajouter des pages permettant de :
    - **Lister** uniquement les annonces de l’agent connecté.
    - **Créer** une nouvelle annonce.
    - **Modifier** une annonce existante, mais uniquement si elle lui appartient.
    - **Supprimer ou désactiver** une annonce, toujours en respectant la propriété.

---

### **3. Contraintes**

- Chaque annonce doit être **rattachée à l’agent** qui l’a créée.
- Les agents ne doivent **jamais voir ou gérer les annonces des autres**.


##  **#4 - Mise en place de la pagination des annonces**

### **1. Accès et périmètre**

- La pagination doit être disponible sur :
    - La page listant uniquement les **appartements**.
    - La page listant uniquement les **maisons**.
- L’utilisateur doit pouvoir naviguer facilement entre les pages (suivante, précédente, numéros).

---

### **2. Fonctionnalités attendues**

- Limiter le nombre d’annonces affichées par page (par exemple 5, 10 ou 20).
- Afficher une **navigation de pagination** claire (ex. << 1 2 3 >>).
- L’utilisateur doit pouvoir cliquer pour voir les pages suivantes/précédentes.
- Le système doit s’adapter automatiquement si le nombre d’annonces est inférieur au nombre par page (ex. moins de 10 annonces → pas de pagination).

---

### **3. Contraintes**

- L’interface doit être **ergonomique et claire** (pas de liens inutiles si une seule page existe).
- Les performances doivent être assurées (ne pas charger toutes les annonces en mémoire d’un coup).


## Technologies

- **Symfony** (version 7.3.3)
- **Doctrine ORM**
- **Twig** pour les templates
- **PHP 8.4+**
- **MySQL**

## A faire
- Ajout des TwigBundles
- Modifier le register pour envoi mail de confirmation => mailer depuis le controller (MailStrap) // ajout du isVerified en bdd
- Admin : ajouter méthodes sur type transaction/propriété (modif', sup')
- API : premiers tests get/post ok, sécurité JWT
