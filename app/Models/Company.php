<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'country',
        'branch',
        'address'
    ];

    protected $dates = ['deleted_at'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class , 'company_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class , 'company_id');
    }
}
