<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;

    protected $table = 'permission';

    protected $fillable = [
        'permission_title',
    ];

    public function Role()
    {
        return $this->belongsToMany('roles');
    }
}
