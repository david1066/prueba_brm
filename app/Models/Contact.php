<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contact extends Model
{
    use HasFactory;
    //eliminacion por softdeltes
    use SoftDeletes;
    public $fillable = [
        'name', 
        'phone', 
        'date_birth', 
        'address', 
        'email'
    ];
    protected $table='contacts';
    protected $appends = ['year'];
    public function getYearAttribute()
    {
        $date = Carbon::now();
        // siendo $vigencia la fecha que traes de la tabla
        $date_birth = Carbon::parse($this->date_birth);
        
        $diff = $date_birth->diffInYears($date);
       
        return $diff ;
    }

}
