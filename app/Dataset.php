<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $table = 'tbl_dataset';
    protected $primaryKey = 'dts_id';

    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';

    protected $fillable = [
        'ogz_id', 
        'dts_title', 
        'dts_url', 
        'dts_description', 
        'dts_status', 
        'lcs_id', 
        'create_date', 
        'create_by', 
        'update_date', 
        'update_by', 
        'record_status'
    ];

    public function Organization(){
        return $this->hasMany('App\Organization', 'ogz_id', 'dts_id');
    }

}
