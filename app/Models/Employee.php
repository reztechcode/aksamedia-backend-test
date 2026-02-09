<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'image',
        'name',
        'phone',
        'position',
        'division_id',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m)=> $m->id = (string) Str::uuid());
    }
}
