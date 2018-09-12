<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userdownload extends Model
{
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $primaryKey = 'dnl_id';
    
    protected $table = 'tbl_userdownload';
    protected $fillable = ['res_id','first_name','last_name','description','create_date','create_by','update_date','update_by','record_status'];
}
