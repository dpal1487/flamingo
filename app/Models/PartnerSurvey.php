<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Ramsey\Uuid\Uuid;

class PartnerSurvey extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
    public function getRouteKeyName()
    {
        return 'id';
    }
    use HasFactory;
    protected $fillable = ['uid', 'project_id', 'toid', 'partner_id', 'starting_ip'];

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
    public function projects()
    {
        return $this->hasMany(Project::class, 'id', 'project_id');
    }
    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }
    public function partners()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user');
    }
}
