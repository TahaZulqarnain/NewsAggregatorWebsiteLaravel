<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = ['source','endpoint','request_payload','response_payload','success','error_message'];
}
