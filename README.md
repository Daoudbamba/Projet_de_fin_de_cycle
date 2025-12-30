# Projet de Fin de Cycle (PFC) – Application de Gestion Immobilière

Ce projet est une application web de gestion immobilière développée dans le cadre d’un Projet de Fin de Cycle (PFC).
Il permet la gestion des utilisateurs, des propriétés (appartements), ainsi que l’authentification et la récupération de mot de passe.

---

## 📁 Lancement du site

Le point d’entrée principal de l’application est :

pfc/GestAppart/index.php

C’est ce fichier qui doit être lancé dans le navigateur.

---

## 🛠 Technologies utilisées

- PHP
- MySQL
- HTML / CSS / JavaScript
- Bootstrap
- Serveur local (XAMPP / WAMP / LAMP)

---

## ⚙️ Installation du projet

1. Copier le dossier du projet dans :
   - `htdocs` (XAMPP) ou `www` (WAMP)
2. Importer la base de données MySQL (fichier `.sql`)
3. Configurer la connexion à la base de données dans :
   pfc/GestAppart/database.php
4. Démarrer Apache et MySQL
5. Accéder au site via :
   http://localhost/pfc/GestAppart/index.php

---

## 🔐 Authentification

Le projet inclut :
- Inscription (`register.php`)
- Connexion (`login.php`)
- Déconnexion (`logout.php`)
- Gestion des sessions (`session.php`)

---

## 🔁 Gestion CRUD (principe commun)

La gestion des **appartements**, des **propriétés** et des **utilisateurs** repose sur une même logique CRUD :

- ajouter.php → Ajout
- modifier.php → Modification
- supprimer.php → Suppression
- voir.php → Affichage détaillé
- code.php → Traitement logique
- database.php → Connexion base de données

Toutes les actions passent par `code.php`, qui communique avec la base de données.

---

## 🏠 Gestion des appartements / propriétés

Les propriétés immobilières peuvent être :
- ajoutées
- modifiées
- supprimées
- consultées en détail

Le fichier `voir.php` permet d’afficher le détail d’un appartement ou d’une propriété.

---

## 👤 Gestion des utilisateurs

L’administrateur peut :
- gérer les comptes utilisateurs
- modifier ou supprimer des utilisateurs
- contrôler les accès à l’application

---

## 🔑 Mot de passe oublié

Le dossier `mdp_oublier` permet la récupération de mot de passe via :
- `dmde_password.php` : demande de réinitialisation
- `rein_password.php` : saisie du nouveau mot de passe
- `reset_password.php` : confirmation et mise à jour

Cette fonctionnalité améliore la sécurité et l’autonomie des utilisateurs.

---

## 📊 Diagrammes UML et planification

Le dossier `diagrammes` contient :
- 2 diagrammes de cas d’utilisation (Use Case)
- 3 diagrammes de séquence
- 1 diagramme de classes
- 1 diagramme de Gantt (planification du projet)

Ces diagrammes permettent de comprendre l’architecture et le fonctionnement global du système.

---

## 🎯 Objectifs pédagogiques

- Concevoir une application web dynamique
- Implémenter un CRUD complet
- Gérer une base de données relationnelle
- Mettre en place un système d’authentification sécurisé
- Appliquer les notions de modélisation UML

---

## 👨‍🎓 Auteur

Haidara Bamba  
Projet de Fin de Cycle – Année académique 2024–2025
