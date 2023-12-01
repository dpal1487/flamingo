<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = array('role_id','user_id');

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }
}
