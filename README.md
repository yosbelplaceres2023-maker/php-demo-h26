# php-demo-h26

Mini application PHP + MySQL pour ajouter et afficher des messages.

## Installation

1. Installer les dependances PHP :

```bash
composer install
```

2. Copier le fichier d'environnement :

```bash
cp .env.example .env
```

3. Modifier `.env` avec les informations de la base de donnees.

4. Creer la table MySQL avec `cours_fullstack.sql` dans phpMyAdmin, ou avec :

```bash
mysql -u utilisateur -p nom_de_la_base < cours_fullstack.sql
```

## Structure

- `public/index.php` affiche le formulaire et la liste des messages.
- `public/ajouter.php` ajoute un message.
- `app/db.php` gere la connexion a MySQL.
- `cours_fullstack.sql` cree la table `messages`.
