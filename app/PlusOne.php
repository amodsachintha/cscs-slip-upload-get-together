<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlusOne extends Model
{
    protected $table = 'plus_ones';
    protected $fillable = ['person_id', 'full_name', 'nic'];

    public function person(){
        return $this->belongsTo(Person::class);
    }

}
