<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'completes', 'complete_url', 'terminate_url', 'quotafull_url', 'latter', 'gst_number', 'status'];
    public function type()
    {
        return $this->hasOne(PartnerType::class, 'id', 'partner_type_id');
    }
}
