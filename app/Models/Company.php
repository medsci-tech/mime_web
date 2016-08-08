<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * @package App\Models
 */
class Company extends Model
{
    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function representatives()
    {
        return $this->hasMany(Representative::class, 'company_id');
    }

}
