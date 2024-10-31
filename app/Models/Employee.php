<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'position',
        'dob',
        'phone',
        'address',
        'company_id'
    ];

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function bankAccount(): HasOne
    {
        return $this->hasOne(BankAccount::class);
    }
}
