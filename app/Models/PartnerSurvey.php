<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerSurvey extends Model
{
    use HasFactory;
    protected $fillable=['uid','project_id','toid','partner_id','starting_ip'];

}
