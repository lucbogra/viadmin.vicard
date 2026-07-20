# Vicard Admin

Back-office d'administration pour la plateforme **Vicard** : gestion des cartes prépayées (virtuelles/physiques), des clients porteurs de cartes, des demandes de carte et de rechargement, de la facturation mensuelle des cartes, et des coordonnées bancaires utilisées pour les paiements. L'application s'intègre également à la plateforme externe **CodInvestor** (affiliation/investisseurs).

Cette application est un panneau d'administration interne (accès réservé aux rôles `Admin` et `Account Manager`) — ce n'est pas l'app cliente-finale.

## Stack technique

- **Backend** : Laravel 10, Laravel Jetstream (auth + équipes via Fortify), Sanctum, Spatie Permission (rôles/permissions), Brick/Money (montants monétaires)
- **Frontend** : Inertia.js + Vue 3, Tailwind CSS, PrimeVue, Element Plus, Vite
- **Base de données** : MySQL (connexion principale + connexion secondaire `coddb` vers la base CodInvestor)

## Prérequis

- PHP >= 8.1
- Composer
- Node.js + npm
- MySQL (une base locale + accès à la base `coddb` pour l'intégration CodInvestor)

## Installation

```bash
# Dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate --seed

# Assets front
npm run build   # ou npm run dev en développement
```

Le seeder (`RoleSeeder`) crée les rôles `Admin`, `Account Manager`, `Account Owner`, `Member`, ainsi qu'un compte administrateur par défaut :

- Email : `admin@vicards.net`
- Mot de passe : `password`

**Pensez à changer ce mot de passe avant tout déploiement en production.**

## Variables d'environnement spécifiques

En plus des variables Laravel standard, `.env` doit définir :

```bash
# Connexion à la base CodInvestor (intégration affiliation)
COD_HOST=
COD_PORT=
COD_DATABASE=
COD_USERNAME=
COD_PASSWORD=

# Liens API CodInvestor
COD_INVESTOR_API_LINK=affiliate.codinvestor.com
COD_INVESTOR_ADMIN_API_LINK=adminapp.codinvestor.com

# Coûts de facturation des cartes (en unités entières, pas en centimes)
CARD_BILLING_FIRST_CARD_COST=29
CARD_BILLING_OTHER_CARDS_COST=5

# Devises
CURRENCY=AED           # devise de fonctionnement des cartes
INVOICE_CURRENCY=USD   # devise de facturation
```

## Lancer le projet en développement

```bash
php artisan serve
npm run dev
```

## Tests

```bash
php artisan test
# ou
vendor/bin/phpunit
vendor/bin/phpunit --filter NomDuTest
```

## Lint / formatage PHP

```bash
vendor/bin/pint
```

## Commande de facturation

La facturation mensuelle des cartes activées se lance via :

```bash
php artisan bill:cards {jour?} {mois?}
```

Elle est planifiée automatiquement (`bill:cards lm`, tous les mois) dans `App\Console\Kernel`. Pour chaque carte activée, une facture (`Invoice`) est générée selon le rang de la carte chez son propriétaire (1ère carte = `CARD_BILLING_FIRST_CARD_COST`, suivantes = `CARD_BILLING_OTHER_CARDS_COST`), avec notification au client.

## Fonctionnalités principales

- **Clients & cartes** : consultation des clients, de leurs cartes, membres associés à une carte, transactions et factures
- **Demandes de carte** (`CardRequest`) : validation/rejet des demandes d'émission de nouvelles cartes
- **Demandes de rechargement** (`CardTopUpRequest`) : validation/rejet des demandes de top-up de solde
- **Facturation** : suivi des factures, statut de paiement (payée / en attente de confirmation / rejetée / en attente)
- **Banques** : gestion des coordonnées bancaires de la plateforme, affichées aux clients pour les paiements par virement
- **Intégration CodInvestor** : rapprochement entre les utilisateurs Vicard et les comptes affiliés/investisseurs CodInvestor via une connexion base de données dédiée

## Structure du projet

```
app/
  Console/Commands/     Commandes artisan (ex: facturation des cartes)
  Http/Controllers/      Contrôleurs (Customers, Cards, Invoices, Banks, Requests, CodInvestor/...)
  Models/                Modèles Eloquent (Card, CardRequest, CardTopUpRequest, Invoice, Transaction, Bank, User, ...)
  Models/CodInvestor/    Modèles pointant vers la base externe CodInvestor (connexion `coddb`)
  Services/              AppMenu (menu admin), AppService (formatage montants/dates, notifications)
  Casts/                 Cast Money (Brick\Money) pour les colonnes monétaires
  Observers/             TransactionObserver (mise à jour automatique du solde des cartes)
  Rules/                 Règles de validation métier (limites de carte)
resources/js/
  Pages/                 Pages Inertia (une arborescence par section d'admin)
  Layouts/               Layouts partagés (dont la sidebar dans Layouts/Aside)
  Components/            Composants Vue partagés (dont un composant Table générique)
routes/web.php           Toutes les routes admin (protégées par auth + rôle admin)
```

## Licence

Ce projet est basé sur le framework [Laravel](https://laravel.com), open-source sous licence MIT.
