<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_name', 'gender', 'min_age','max_age','industry_id', 'user_id', 'device_type', 'client_id', 'project_id', 'country', 'client_live_url', 'client_test_url', 'cost', 'time', 'incedance_rate', 'number_of_complete', 'end_date', 'remarks', 'status'];
    public function surveys()
    {
        return $this->hasMany(Survey::class, 'pid', 'id');
    }

    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }

    public function client()
    {
        return $this->hasOne(Partner::class, 'id', 'client_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'user_id');
    }
}
