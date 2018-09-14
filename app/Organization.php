<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'tbl_organization';
    protected $primaryKey = 'ogz_id';

    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';

    protected $fillable = [
        'ogz_title', 
        'ogz_url', 
        'ogz_description', 
        'ogz_status', 
        'ogz_image', 
        'create_date', 
        'create_by', 
        'update_date', 
        'update_by', 
        'record_status'
    ];
}
