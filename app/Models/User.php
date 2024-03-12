<?php

namespace App\Models;

use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasUuids;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'cod_investor_id', 'type', 'team'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hash'
    ];

    protected $with = [
        'roles'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    const CUSTOMERS_ROLE_ACCOUNT_OWNER = ['Account Owner'];

    const CUSTOMERS_ROLE_LISTS = ['Account Owner', 'Member'];

    const ADMINS_ROLE_LISTS = ['Admin', 'Account Manager'];

    public function scopeSearch($builder, $term) {
        $builder->where("name", "LIKE", "%$term%")
                ->orWhere("email", "LIKE", "%$term%");
    }

    public function scopeAccountOwners($builder) {
        $builder->whereHas("roles", function($query) {
            $query->where("roles.name", User::CUSTOMERS_ROLE_ACCOUNT_OWNER);
        });
    }

    public function scopeCustomers($builder) {
        $builder->whereHas("roles", function($query) {
            $query->whereIn("roles.name", User::CUSTOMERS_ROLE_LISTS);
        });
    }

    public function cards(): BelongsToMany {

        return $this->belongsToMany(Card::class)->withPivot('permissions', 'owner');

    }

    public function owner(): HasMany {

        return $this->hasMany(Card::class, 'owner_id');

    }

    public function cardRequests(): HasMany {

        return $this->hasMany(CardRequest::class);

    }

    public function cardTopUpRequests(): HasMany {

        return $this->hasMany(CardTopUpRequest::class);

    }

    public function invoices(): HasMany {

        return $this->hasMany(Invoice::class, 'customer_id');

    }

}
