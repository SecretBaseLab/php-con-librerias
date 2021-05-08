<?php

namespace App\Controllers;

use App\Models\user;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse; 

class AuthController extends BaseController{
    public function getLoginAction(){
        return $this->renderHTML('login.twig');
    }

    public function postLoginAction($request){
        $responseMessage = null;

        if ($request->getMethod() == 'POST') {
            //? v::attribute para objs V::key para arrays
            $postData = $request->getParsedBody();
            $user = user::where('email', $postData['email'])->first();
            if ($user)
                if (password_verify($postData['password'], $user->password)){
                    $_SESSION['userId'] = $user->id;
                    return new RedirectResponse('/admin');
                }else
                    $responseMessage = 'Bad credentials';
            else
                $responseMessage = 'Bad credentials';

            $projectValidator = v::key('email', v::stringType()->noWhitespace()->email())
                ->key('password', v::stringType()->notEmpty()->noWhitespace());
        }
        // include '../views/addProject.php';
        return $this->renderHTML('login.twig', [
            'responseMessage' => $responseMessage
        ]);
    }

    public function getLogoutAction(){
        unset($_SESSION['userId']);
        return new RedirectResponse('/login');
    }
}
