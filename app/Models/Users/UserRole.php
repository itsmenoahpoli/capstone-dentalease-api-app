<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    protected $guarded = [];

    public function users() : HasMany
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
