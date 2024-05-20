<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'role_title',
    ];

    public function permissions()
    {
        return $this->hasMany(Permissions::class,'id');
    }


}
