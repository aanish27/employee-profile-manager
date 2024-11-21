<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'position',
        'dob',
        'phone',
        'address',
        'company_id'

    ];

    public function company()
    {
        return $this->belongsTo(Company::class , 'company_id', 'id')->withTrashed();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class , 'employee_project' , 'project_id');
    }

    public function bankAccount(): HasOne
    {
        return $this->hasOne(BankAccount::class , 'employee_id' , 'id');
    }
}
