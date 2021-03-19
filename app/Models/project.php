<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class project extends Model{
    protected $table = 'project';

    public function getDurationAsString() {
		return '';
	}

}