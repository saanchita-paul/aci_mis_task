<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'salary',
        'start_date'
    ];


    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function getOrganizationAttribute()
    {
        return $this->team ? $this->team->organization : null;
    }


    public function scopeStartedAfter($query, $date) {
        return $query->where('start_date', '>=', $date);
    }

}
