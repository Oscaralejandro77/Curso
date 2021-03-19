<?php

namespace app\controllers;
use app\Models\{job, project};

class adminController extends baseController{
    public function getIndex(){

        return $this->renderHTML('admin.twig');
    }
}