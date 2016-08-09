<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    //
    protected $table = 'representatives';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
