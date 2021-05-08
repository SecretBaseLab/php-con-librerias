<?php

namespace App\Controllers;

use App\Models\user;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController
{
    public function getLoginAction(){   
        $sessionUserId = $_SESSION['userId'] ?? null;
        if( $sessionUserId )
        return new RedirectResponse('/admin');
        else
            return $this->renderHTML('login.twig');
    }

    public function postLoginAction($request)
    {
        $responseMessage = null;

        if ($request->getMethod() == 'POST') {
            $postData = $request->getParsedBody();

            //? v::attribute para objs V::key para arrays
            //validando datos
            $authValidator = v::key('email', v::stringType()->noWhitespace()->email())
                ->key('password', v::stringType()->notEmpty()->noWhitespace());

            try {
                $authValidator->assert($postData);  //verifica si los datos con correctos sino da error fatal

                $user = user::where('email', $postData['email'])->first();
                if ($user)
                    if (password_verify($postData['password'], $user->password)) {
                        $_SESSION['userId'] = $user->id;
                        return new RedirectResponse('/admin');
                    } else
                        $responseMessage = 'Bad credentials';
                else
                    $responseMessage = 'Bad credentials';
            } catch (\Exception $e) {
                $responseMessage = 'Bad credentials';
            }
        }
        // include '../views/addProject.php';
        return $this->renderHTML('login.twig', [
            'responseMessage' => $responseMessage
        ]);
    }

    public function getLogoutAction()
    {
        unset($_SESSION['userId']);
        return new RedirectResponse('/login');
    }
}
