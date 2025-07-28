<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'team_id',
        'name',
        'salary',
        'start_date'
    ];


    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function scopeStartedAfter($query, $date) {
        return $query->where('start_date', '>=', $date);
    }

}
