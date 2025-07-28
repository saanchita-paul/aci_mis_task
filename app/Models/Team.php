<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'organization_id',
        'name'
    ];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

}
