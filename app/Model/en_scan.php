<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class en_scan extends Model
{
    protected $table = 'en_scan';

    public function scan()
    {
        return $this->hasOne('App\Model\en_scan_complete', 'file', 'FILE');
    }
}
