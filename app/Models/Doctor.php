<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = [];

    public function hospital()
    {
        return $this->belongsTo('App\Model\Hospital', 'hospital_id');
    }
    public function officeRecord()
    {
        return $this->belongsTo('App\Model\Office', 'office','office_id');
    }
}
