<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

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