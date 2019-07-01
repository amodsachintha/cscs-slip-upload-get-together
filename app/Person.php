<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';
    protected $fillable = [
        'full_name', 'it_number', 'grad_year', 'grad_month',
        'personal_email', 'work_email', 'phone', 'total_amount'
    ];


    public function plusOne(){
        return $this->hasOne(PlusOne::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
