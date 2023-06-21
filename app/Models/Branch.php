<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    public function cats(): HasMany
    {
        return $this->hasMany(Cat::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
