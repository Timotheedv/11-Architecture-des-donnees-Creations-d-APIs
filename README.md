# 🚀 API Picard - Guide de Développement Complet

Présentation de mon projet

Ce projet permet de gérer :

- 🛒 un catalogue de produits
- 🧺 des paniers d'achat
- ⭐ un système de notation


## 🎥 Vidéo Explicative

Lien Youtube: 

https://youtu.be/3wJPFb2P8ag


## Documentation utilisée

https://www.youtube.com/watch?v=NtRDYo7w4s8
https://koul.io/blog/api-platform-une-solution-web-puissante-pour-construire-des-apis-modernes
https://api-platform.com/docs/symfony/

## ⚙️ Installation et Setup Initial

### 1. Création du projet

```bash
composer create-project symfony/skeleton picard-api
cd picard-api
git init
git add .
git commit -m "feat: initial Symfony project setup"
```

### 2. Installation des dépendances

```bash
composer require api-platform/core
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

### 3. Configuration de la base de données

Créer `.env.local` :

```env
# Pour XAMPP
DATABASE_URL="mysql://root:@127.0.0.1:3306/picard_api"
```

### 4. Création de la base

```bash
php bin/console doctrine:database:create
```

---

## 🧱 Création des Entités

### 📦 Product

```bash
php bin/console make:entity Product
```
Champs : `name`, `description`, `price`, `image`, `rating`, `available`

### 🛒 Cart

```bash
php bin/console make:entity Cart
```
Champs : `status`, `createdAt`, `validatedAt`

### 🧾 CartItem

```bash
php bin/console make:entity CartItem
```
Champs : `quantity` + relations avec `Product` et `Cart`

### ⭐ Rating

```bash
php bin/console make:entity Rating
```
Champs : `score` + relation avec `Product`

---

## 📡 Configuration API Platform

### ⚙️ Migrations

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### 🧩 Annotations sur les entités

Ajouter `#[ApiResource]` + opérations nécessaires (`Get`, `Post`, `Put`, `Delete`, etc.)

---

## 🧪 Test de l'API

```bash
symfony server:start
symfony server:stop

```

Accéder à la documentation Swagger :  
🌐 [http://localhost:8000/api/docs]

---

## 🔍 Fonctionnalités Avancées

### ✅ Validation du panier

Créer un contrôleur personnalisé :

```php
#[Route('/api/carts/{id}/validate', methods: ['POST'])]
```


## 🧪 Données de Test

### 1. Installation des Fixtures

```bash
composer require --dev doctrine/doctrine-fixtures-bundle
php bin/console make:fixtures ProductFixtures
```

### 2. Chargement des données

```bash
php bin/console doctrine:fixtures:load
```

---

## 🔒 Validation & Tests

### Contraintes de validation

Utiliser les annotations :

```php
#[Assert\NotBlank]
#[Assert\Positive]
#[Assert\Length(min: 3, max: 255)]
```


---

## 🔗 Endpoints Disponibles

GET /api/products
➜ Liste tous les produits disponibles.

GET /api/products/{id}
➜ Affiche les détails d’un produit spécifique.

POST /api/cart_items
➜ Ajoute un produit au panier.

DELETE /api/cart_items/{id}
➜ Supprime un produit du panier.

POST /api/carts/{id}/validate
➜ Valide un panier.

POST /api/ratings
➜ Permet de noter un produit.






