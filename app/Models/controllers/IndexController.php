<?php

namespace app\controllers;
use app\Models\{job, project};

class indexController{
    public function indexAction1(){

        $jobs = job::all();
        $projects = Project::all();

        /*$project1 = new project('project 1', 'description 1');
        $projects = [
         $project1
        ];*/

         $name = "Oscar Alejandro";
        $limitMonths = 2000;

        include '../views/index.php';

    }
}