<?php

namespace app\controllers;
use app\Models\{job, project};

class indexController extends baseController{
    public function indexAction(){

        $jobs = job::all();
        //$projects = Project::all();

        /*$project1 = new project('project 1', 'description 1');
        $projects = [
         $project1
        ];*/
        /*$limitMonths = 15;
        $filterFunction = function(array $job) use($limitMonths) {//trar variable de un scop superior
            return $job['months'] >= $limitMonths;
        };

        $jobs = array_filter($jobs->toArray(),$filterFunction);

        //convierte a arreglo, filtra información
        /*$jobs = array_filter($jobs->toArray(), function($job){
            return $job['months'] >= 10;
        });*/

         $name = "Oscar Alejandro";


        return $this->renderHTML('index.twig', [
            'name' => $name,
            'jobs' => $jobs
        ]);
    }
}