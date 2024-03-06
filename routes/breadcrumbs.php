<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Bank;
use App\Models\Card;
use App\Models\User;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Customers
Breadcrumbs::for('customers.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Customer Lists', route('customers.index'));
});

Breadcrumbs::for('customers.create', function (BreadcrumbTrail $trail) {
    $trail->parent('customers.index');
    $trail->push('New Customer', route('customers.create'));
});

Breadcrumbs::for('card-requests.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Card Requests', route('card-requests.index'));
});

Breadcrumbs::for('topup-requests.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Topup Requests', route('topup-requests.index'));
});

Breadcrumbs::for('customers.show', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.index');
    $trail->push('Show Customer', route('customers.show', $customer));
});

Breadcrumbs::for('customers.edit', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.show', $customer);
    $trail->push('Edit Customer', route('customers.edit', $customer));
});

Breadcrumbs::for('customers.cards.index', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.show', $customer);
    $trail->push('Cards', route('customers.cards.index', $customer));
});

Breadcrumbs::for('customers.cards.show', function (BreadcrumbTrail $trail, User $customer, Card $card) {
    $trail->parent('customers.cards.index', $customer);
    $trail->push('Details', route('customers.cards.show', [$customer, $card]));
});

Breadcrumbs::for('customers.cards.transactions', function (BreadcrumbTrail $trail, User $customer, Card $card) {
    $trail->parent('customers.cards.show', $customer, $card);
    $trail->push('Transactions', route('customers.cards.transactions', [$customer, $card]));
});

Breadcrumbs::for('customers.cards.members', function (BreadcrumbTrail $trail, User $customer, Card $card) {
    $trail->parent('customers.cards.show', $customer, $card);
    $trail->push('Members', route('customers.cards.members', [$customer, $card]));
});

Breadcrumbs::for('customers.card-requests.index', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.show', $customer);
    $trail->push('Requests', route('customers.cards.index', $customer));
});

Breadcrumbs::for('customers.topup-requests.index', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.show', $customer);
    $trail->push('Top Up Requests', route('customers.topup-requests.index', $customer));
});

Breadcrumbs::for('customers.invoices.index', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.show', $customer);
    $trail->push('Invoices', route('customers.invoices.index', $customer));
});

Breadcrumbs::for('cards.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Card Lists', route('cards.index'));
});

// Bank Lists
Breadcrumbs::for('settings.banks.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Bank Lists', route('settings.banks.index'));
});

Breadcrumbs::for('settings.banks.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.banks.index');
    $trail->push('New Bank', route('settings.banks.create'));
});

Breadcrumbs::for('settings.banks.edit', function (BreadcrumbTrail $trail, Bank $bank) {
    $trail->parent('settings.banks.index');
    $trail->push('Edit Bank', route('settings.banks.edit', $bank));
});