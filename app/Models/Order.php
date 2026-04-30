<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
