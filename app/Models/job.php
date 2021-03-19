<?php

namespace app\Models;

use app\traits\HasDefaultImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class job extends Model{
    use HasDefaultImage;
    use SoftDeletes;

    protected $table = 'jobs';

    public function getDurationAsString(){
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;
        
      
        if($years < 1){
          return "$extraMonths months";
        } else if($extraMonths < 1){
          return "$years years";
        } else {
          return "Duracion de trabajos: $years years $extraMonths months";
        }
      }
}
