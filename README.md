# 🎵 R209 - Site de Vente de Musique (PHP & SQL)

Projet réalisé dans le cadre de la SAE R209, consistant à développer un site dynamique de vente de musique en PHP, avec une base de données MySQL.

## 🔧 Technologies utilisées

- PHP
- MySQL
- HTML/CSS
- XAMPP (Apache + MySQL)
- Navigateur web (Chrome, Firefox...)

## 🚀 Installation & Lancement

### Pré-requis

- [XAMPP](https://www.apachefriends.org/fr/index.html) installé sur votre machine (ou un serveur Apache/MySQL équivalent)
- Un éditeur de texte comme VS Code, Sublime Text, ou autre

### Étapes Windows

1. **Télécharger et extraire le projet**  
   Téléchargez le projet et extrayez l'archive `.zip`.

2. **Placer le projet dans XAMPP**  
   Déplacez le dossier `site` dans le répertoire suivant :  
   `C:\xampp\htdocs\`

3. **Lancer XAMPP**  
   Démarrez le module **Apache** (et **MySQL** si vous devez configurer ou visualiser la base).

4. **Accéder au site**  
   Dans votre navigateur, entrez l'une des adresses suivantes :  
###  Étapes Linux

1. **Télécharger php**
Télécharger php via la commande `sudo apt install php`

3. **Télécharger et extraire le projet**
   Téléchargez le projet et extrayez l'archive `.zip`.

4. **Se mettre dans le dossier et lancer php**

  Pour se mettre dans le dossier du projet utiliser la commande `cd chemin/vers/projet`
  Ensuite utiliser la commande `php - S localhost:8000` pour lancer php.

5. **Pour aller sur le site**
   Pour aller sur le site il faut taper `localhost:8000/main.php` dans la barre de recherche du navigateur pour accèder à la page d'acceuil.

---
 
## 📄 Pages du site

Chaque page du site est dynamique et utilise PHP pour interagir avec la base de données :

- `main.php` : page d'accueil avec liens vers les principales sections
- `login.php` : connexion utilisateur
- `register.php` : création de compte utilisateur
- `catalogue.php` : affichage de tous les morceaux disponibles
- `artiste.php` : page dédiée à un artiste (bio, albums, etc.)
- `peoduit.php` : page détaillée d’un morceau avec options d’achat
- `panier.php` : gestion du panier (ajout, suppression, validation)

Des fichiers annexes assurent les connexions à la base (`ajout_produit.php`, `script_login.php`, etc.) et la gestion des sessions utilisateur.

---

## 👥 Auteurs

Projet réalisé par :
- **MeXam_**
- **Epilow**

---

## 📌 Remarques

- Le projet a été testé sous Windows avec XAMPP rt linux via **PHP**.
- Vérifiez que le module `mysql` est activé dans votre configuration PHP.
- N'oubliez pas de lancer Apache **et** MySQL avant d'accéder au site.
