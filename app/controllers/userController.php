<?php

namespace app\controllers;
use app\Models\user;
use Respect\Validation\Validator as v;

class userController extends baseController {
    public function getAddUser() {
        return $this->renderHTML('addUser.twig');
    }

    public function postSaveUser($request) {
        $postData = $request->getParsedBody();

        //validacion
        $user = new user();
        $user->email = $postData['email'];
        $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
        $user->save();
        return $this->renderHTML('addUser.twig');
    }

}