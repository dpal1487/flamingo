<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable=['id','project_name','industry_id','client','project_id','country','client_live_url','client_test_url','cost','time','incedance_rate','number_of_complete','end_date','remarks','status'];
	/*public function surveys()
	{
		return $this->hasMany(Surveys::class,'pid','id');
	}*/
}
