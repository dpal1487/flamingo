<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerProjects extends Model
{
    use HasFactory;
    protected $fillable=['partner_id', 'project_id','partner_name','survey_link','cost','number_of_completes','message','remarks','complete_url','terminate_url','quotafull_url','status'];
    public function project()
    {
    	return $this->hasOne(Projects::class, 'id','project_id');
    }
}
