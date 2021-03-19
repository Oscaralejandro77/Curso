<?php

namespace app\controllers;
use app\Models\user;
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;

class authController extends baseController {
    public function getLogin() {
        return $this->renderHTML('login.twig');
    }

    public function postLogin(ServerRequest $request) {
        $postData = $request->getParsedBody();
        $responseMessage = null;

        $user = user::where('email', $postData['email'])->first();
        if($user){
            if(password_verify($postData['password'], $user->password)){
                $_SESSION['userId'] = $user->id;
                return new RedirectResponse('/Curso/admin');
            }else{
                $responseMessage = 'Bad Credencials';
            }
        }else{
            $responseMessage = 'Bad Credencials';
        }

        return $this -> renderHTML('login.twig', [
            'responseMessage' => $responseMessage
        ]);
    }

    public function getLogout() {
        unset($_SESSION['userId']);
                return new RedirectResponse('login');
    }


}