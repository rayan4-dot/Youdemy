# Youdemy - Plateforme de Cours en Ligne

Youdemy est une plateforme d'apprentissage en ligne conçue pour offrir une expérience d'apprentissage interactive et personnalisée pour les étudiants et les enseignants. Elle propose diverses fonctionnalités pour la navigation dans les cours, l'inscription, la gestion, et la supervision administrative.

## Fonctionnalités

### Front Office :

#### Visiteur :
- **Catalogue des Cours** : Accès à un catalogue paginé de cours.
- **Fonction de Recherche** : Recherche de cours par mots-clés.
- **Création de Compte** : Les utilisateurs peuvent créer un compte et choisir entre deux rôles :
  - **Étudiant**
  - **Enseignant**

#### Étudiant :
- **Navigation dans les Cours** : Voir et rechercher parmi le catalogue des cours.
- **Détails des Cours** : Consulter les informations détaillées sur les cours (description, contenu, enseignant, etc.).
- **Inscription aux Cours** : Les étudiants peuvent s'inscrire aux cours après authentification.
- **Mes Cours** : Une section personnalisée montrant les cours auxquels l'étudiant est inscrit.

#### Enseignant :
- **Ajouter des Cours** : Les enseignants peuvent ajouter de nouveaux cours avec les détails suivants :
  - Titre, Description, Contenu (vidéo ou document), Tags, Catégorie
- **Gérer les Cours** : Les enseignants peuvent modifier, supprimer et consulter les inscriptions à leurs cours.
- **Statistiques** : Accès à des statistiques sur les cours, telles que :
  - Nombre d'étudiants inscrits, Nombre de cours, etc.

### Back Office :

#### Administrateur :
- **Validation des Comptes Enseignants** : L'administrateur peut valider les comptes enseignants.
- **Gestion des Utilisateurs** : Activation, suspension ou suppression des comptes utilisateurs.
- **Gestion des Contenus** : Gestion des cours, catégories et tags.
- **Insertion en Masse de Tags** : Permet d'insérer des tags en masse pour gagner en efficacité.
- **Statistiques Globales** : Accès à des statistiques globales, telles que :
  - Nombre total de cours, Répartition par catégorie, Cours avec le plus d'étudiants, Top 3 des enseignants.

### Fonctionnalités Transversales :
- **Relation Many-to-Many** : Un cours peut contenir plusieurs tags, et un tag peut être associé à plusieurs cours.
- **Polymorphisme** : Application du concept de polymorphisme dans des méthodes comme "Ajouter un cours" et "Afficher un cours".
- **Authentification & Autorisation** : Protection des routes sensibles, garantissant que seuls les utilisateurs autorisés accèdent aux fonctionnalités appropriées.
- **Contrôle d'Accès** : Chaque utilisateur ne peut accéder qu'aux fonctionnalités correspondant à son rôle.

## Exigences Techniques

- **Principes OOP** : Respect des principes de l'orienté objet, tels que l'encapsulation, l'héritage et le polymorphisme.
- **Base de Données Relationnelle** : Gestion des relations dans la base de données (one-to-many, many-to-many).
- **Sessions PHP** : Utilisation des sessions pour gérer les utilisateurs connectés.
- **Validation des Données** : Système de validation pour garantir la sécurité des données utilisateur.

## Installation

1. Clonez le dépôt sur votre machine locale 😀
   
   ```bash
   git clone https://github.com/rayan4-dot/Youdemy
