<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'date',
        'time',
        'location',
        'created_by',
    ];
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
