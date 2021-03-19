<?php


namespace app\services;

use app\Models\job;

class jobService
{
    public function deleteJob ($id){
        $job = job::findOrFail($id);
        /*if(!$job){
            throw new \Exception('Job not found');
        }*/
        $job->delete();

    }
}