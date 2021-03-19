<?php

namespace app\controllers;
use app\services\jobService;
use app\Models\{job, project};
use Respect\Validation\Validator as v;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;


class jobsController extends baseController{
    private $jobService;

    public function __construct(jobService $jobService)
    {
        parent::__construct();
        $this->jobService = $jobService;
    }

    public function indexAction(){
        $jobs = job::withTrashed()->get();
        return $this->renderHTML('jobs/index.twig', compact('jobs'));
    }

    public function deleteAction(ServerRequest $request) {
        $params = $request->getQueryParams();
        $this->jobService->deleteJob($params['id']);

        return new RedirectResponse('/Curso/jobs');
    }

    public function getAddJobAction($request){
        $responseMessage = null;

        if ($request->getMethod() == 'POST'){
            $postData = $request->getParsedBody();
            $jobValidator = v::key('title', v::stringType()->notEmpty())
                  ->key('description', v::stringType()->notEmpty());

            try{
                $jobValidator->assert($postData);

                $files = $request->getUploadedFiles();
                $logo = $files['logo'];

                if($logo->getError() == UPLOAD_ERR_OK){
                    $fileName = $logo->getClientFilename();
                    $logo->moveTo("uploads/$fileName");
                }
                $postData = $request->getParsedBody();
                $job = new job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job -> fileName = $fileName;
                $job->save();

                $responseMessage = 'Saved';
            } catch(\Exception $e){
                $responseMessage = $e->getMessage();
            }
        
        }

        /*if ($request->getMethod() == 'POST') {
            $postData = $request->getParsedBody();
            $project = new project();
            $project->title = $postData['title'];
            $project->description = $postData['description'];
            $project->save();
        }*/
        

       return $this->renderHTML('addjob.twig', [
           'responseMessage' =>$responseMessage
       ]);
    }
}

