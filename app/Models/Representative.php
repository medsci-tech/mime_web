<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    //
    protected $table = 'representatives';

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

}
