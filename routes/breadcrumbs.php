<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Bank;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
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

Breadcrumbs::for('customers.card-requests.index', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.show', $customer);
    $trail->push('Card Requests', route('customers.cards.index', $customer));
});

Breadcrumbs::for('customers.topup-requests.index', function (BreadcrumbTrail $trail, User $customer) {
    $trail->parent('customers.show', $customer);
    $trail->push('Top Up Requests', route('customers.topup-requests.index', $customer));
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