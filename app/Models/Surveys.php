<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Surveys extends Model
{
    protected $fillable=['pid','uid','vid','toid','starting_ip','end_ip','status','start','end'];
}
